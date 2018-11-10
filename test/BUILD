package(default_testonly = 1)

load("//php:php.bzl",
     "php_library",
     "php_binary",
     "php_test")

php_library(
    name = "HelloLib",
    srcs = ["hello.php"],
)

php_binary(
    name = "TestBinary",
    src = "test.php",
    deps = [":HelloLib"],
)


php_test(
    name = "ExampleTest",
    src = "ExampleTest.php",
)
