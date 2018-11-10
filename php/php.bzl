"""Rules for supporting the PHP langauge."""

PHP_FILETYPES = FileType([".php"])

_php_srcs_attr = attr.label_list(allow_files = PHP_FILETYPES)

def collect_transitive_sources(ctx):
    source_files = depset(order="postorder")
    for dep in ctx.attr.deps:
        source_files += dep.transitive_php_files
    return source_files

def _php_library_impl(ctx):
    print(dir(ctx.executable._phan))

    cmd = "%s %s" % (ctx.executable._phan.path, PHP_FILETYPES.filter(ctx.files.srcs))
    print(cmd)

    # TODO ctx.file_action(
    #        output=ctx.outputs.executable,
    #    content="#!/bin/bash\n%s" % cmd,
    #    executable=True
    #    )
    transitive_sources = collect_transitive_sources(ctx)
    transitive_sources += PHP_FILETYPES.filter(ctx.files.srcs)
    return struct(
        files = depset(),
        transitive_php_files = transitive_sources)

php_deps_attr = attr.label_list(
    providers = ["transitive_php_files"],
    allow_files = False,
)

def _php_binary_impl(ctx):
    php = ctx.file._php
    options = [
        "-cvf",
        "TestBinary.tar"
    ]

    # Load up all the transitive sources as dependent includes.
    transitive_sources = collect_transitive_sources(ctx)
    for src in transitive_sources:
        options += [src.path]


    ctx.action(      
        inputs = list(transitive_sources),
        command = "touch %s" % (ctx.outputs.tar_file.path),
        outputs = [ctx.outputs.tar_file],
    )

def _php_test_impl(ctx):
    print(dir(ctx.executable._php))

    cmd = "%s -d allow_url_fopen=On -d detect_unicode=Off %s %s" % (ctx.executable._php.path, ctx.executable._phpunit.path, ctx.file.src.path)
    print(cmd)
    # junit_xml_output=File(ctx.file.src.path + ".xml")
    # print(junit_xml_output)
    # /usr/bin/env php -d allow_url_fopen=On -d detect_unicode=Off /usr/local/Cellar/phpunit/6.2.3/libexec/phpunit-6.2.3.phar "$@"
    #ctx.action(      
    #    inputs = list(transitive_sources) + [ctx.file.src],
    #    command = cmd,
    #    outputs = [ctx.outputs.junit_xml]
    #)
    ctx.file_action(
      output=ctx.outputs.executable,
      content="#!/bin/bash\n%s" % cmd,
      executable=True
    )

    # Load up all the transitive sources as dependent includes.
    transitive_sources = collect_transitive_sources(ctx)
    print(transitive_sources)
    test_inputs = ([ctx.file.src, ctx.executable._php, ctx.executable._phpunit] + list(transitive_sources))

    return struct(
        runfiles=ctx.runfiles(
            files=test_inputs,
            collect_data=True,
        )
    )

def _phar_library(ctx):
    print(dir(ctx))
    native.http_file(
        name = ctx.name,
        sha256 = ctx.attr.sha256,
        url = ctx.attr.url,
    )

# Create an executable PHAR archive
php_binary = rule(
    attrs = {
        "src": attr.label(
            allow_files = PHP_FILETYPES,
            mandatory = True,
            single_file = True,
        ),
        "deps": php_deps_attr,        
        "_php": attr.label(
          default = Label("//third_party/php:php"),
          executable = True,
          cfg = "host",
          single_file = True,
        )
    },
    outputs = {
        "tar_file": "%{name}.tar",
    },
    implementation = _php_binary_impl,
)

php_library = rule(
    attrs = {
        "srcs": attr.label_list(
            allow_files = PHP_FILETYPES,
            non_empty = True,
            mandatory = True,
        ),        
        "deps": php_deps_attr,
        "_phan": attr.label(
            default = Label("@phan//file"),
            executable = True,
            cfg = "host",
            single_file = True,
        )
    },
    implementation = _php_library_impl,
)

php_test = rule(
    attrs = {
        "src": attr.label(
            allow_files = PHP_FILETYPES,
            mandatory = True,
            single_file = True,
        ),
        "deps": php_deps_attr,        
        "_php": attr.label(
          default = Label("//third_party/php:php"),
          executable = True,
          cfg = "host",
          single_file = True,
        ),
        "_phpunit": attr.label(
          default = Label("//third_party/phpunit:phpunit"),
          executable = True,
          cfg = "host",
          single_file = True,
        )        
    },
    executable = True,
    test = True,
    implementation = _php_test_impl,
)

phar_library = rule(
    attrs = {
        "phar": attr.label(),
    },
    implementation = _phar_library,
)

def php_repositories():
    print("loading phan")
    native.http_file(
        name = "phan",
        sha256 = "715acd5500387bbe7b565fec02562f0bdc5f727a85397b4479852f26f5ed8ec2",
        url = "https://github.com/etsy/phan/releases/download/0.9.4/phan.phar",
    )

    # TODO composer.phar perhaps?
    # https://getcomposer.org/download/1.4.3/composer.phar
