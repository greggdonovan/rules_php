# PHP Rules

<div class="toc">
  <h2>Rules</h2>
  <ul>
    <li><a href="#php_library">php_library</a></li>
    <li><a href="#php_binary">php_binary</a></li>
    <li><a href="#php_test">php_test</a></li>
  </ul>
</div>

## Overview

This rule is used for building [PHP][php] projects with Bazel. There are currently three rules, `php_library`, `php_binary`, and `php_test`.

## Getting started

In order to use `php_library`, `php_binary`, and `php_test`, you must have bazel 0.5.3 or later and add the following to your WORKSPACE file:

```python

rules_php="031e73c02e0d8bfcd06c6e4086cdfc7f3a3061a8" # update this as needed

http_archive(
             name = "io_bazel_rules_php",
             url = "https://github.com/greggdonovan/rules_php/archive/%s.zip"%rules_php_version,
             type = "zip",
             strip_prefix= "rules_php-%s" % rules_php_version
             )

load("@io_bazel_rules_php//php:php.bzl", "php_repositories")
php_repositories()
```
To use a particular tag, use the tagged number in `tag = ` and omit the `commit` attribute.
Note that these plugins are still evolving quickly, as is bazel, so you may need to select
the version most appropriate for you.

Then in your BUILD file just add the following so the rules will be available:
```python
load("@io_bazel_rules_php//php:php.bzl", "php_library", "php_binary", "php_test")
```
You may wish to have these rules loaded by default using bazel's prelude. You can add the above to the file `tools/build_rules/prelude_bazel` in your repo (don't forget to have a, possibly empty, BUILD file there) and then it will be automatically prepended to every BUILD file in the workspace.

[php]: http://php.net


#### TODO

- `php_repl` task based on psysh.org