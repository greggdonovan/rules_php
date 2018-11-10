<?php

use \Phan\Issue;

/**
 * This configuration will be read and overlayed on top of the
 * default configuration. Command line arguments will be applied
 * after this file is read.
 *
 * @see src/Phan/Config.php
 * See Config for all configurable options.
 *
 * A Note About Paths
 * ==================
 *
 * Files referenced from this file should be defined as
 *
 * ```
 *   Config::projectPath('relative_path/to/file')
 * ```
 *
 * where the relative path is relative to the root of the
 * project which is defined as either the working directory
 * of the phan executable or a path passed in via the CLI
 * '-d' flag.
 */
return [

    // If true, missing properties will be created when
    // they are first seen. If false, we'll report an
    // error message.
    "allow_missing_properties" => false,

    // Allow null to be cast as any type and for any
    // type to be cast to null.
    "null_casts_as_any_type" => false,

    // Allow null to be cast as any array-like type
    // This is an incremental step in migrating away from null_casts_as_any_type.
    // If null_casts_as_any_type is true, this has no effect.
    'null_casts_as_array' => false,

    // Allow any array-like type to be cast to null.
    // This is an incremental step in migrating away from null_casts_as_any_type.
    // If null_casts_as_any_type is true, this has no effect.
    'array_casts_as_null' => false,

    // If enabled, scalars (int, float, bool, string, null)
    // are treated as if they can cast to each other.
    'scalar_implicit_cast' => false,

    // If this has entries, scalars (int, float, bool, string, null)
    // are allowed to perform the casts listed.
    // E.g. ['int' => ['float', 'string'], 'float' => ['int'], 'string' => ['int'], 'null' => ['string']]
    // allows casting null to a string, but not vice versa.
    // (subset of scalar_implicit_cast)
    'scalar_implicit_partial' => [],

    // If true, seemingly undeclared variables in the global
    // scope will be ignored. This is useful for projects
    // with complicated cross-file globals that you have no
    // hope of fixing.
    'ignore_undeclared_variables_in_global_scope' => false,

    // Backwards Compatibility Checking
    'backward_compatibility_checks' => false,

    // If true, check to make sure the return type declared
    // in the doc-block (if any) matches the return type
    // declared in the method signature. This process is
    // slow.
    'check_docblock_signature_return_type_match' => true,

    // If true, check to make sure the return type declared
    // in the doc-block (if any) matches the return type
    // declared in the method signature. This process is
    // slow.
    'check_docblock_signature_param_type_match' => true,

    // (*Requires check_docblock_signature_param_type_match to be true*)
    // If true, make narrowed types from phpdoc params override
    // the real types from the signature, when real types exist.
    // (E.g. allows specifying desired lists of subclasses,
    //  or to indicate a preference for non-nullable types over nullable types)
    // Affects analysis of the body of the method and the param types passed in by callers.
    'prefer_narrowed_phpdoc_param_type' => true,

    // (*Requires check_docblock_signature_return_type_match to be true*)
    // If true, make narrowed types from phpdoc returns override
    // the real types from the signature, when real types exist.
    // (E.g. allows specifying desired lists of subclasses,
    //  or to indicate a preference for non-nullable types over nullable types)
    // Affects analysis of return statements in the body of the method and the return types passed in by callers.
    'prefer_narrowed_phpdoc_return_type' => true,

    // If enabled, check all methods that override a
    // parent method to make sure its signature is
    // compatible with the parent's. This check
    // can add quite a bit of time to the analysis.
    // This will also check if final methods are overridden, etc.
    'analyze_signature_compatibility' => true,

    // Set to true in order to attempt to detect dead
    // (unreferenced) code. Keep in mind that the
    // results will only be a guess given that classes,
    // properties, constants and methods can be referenced
    // as variables (like `$class->$property` or
    // `$class->$method()`) in ways that we're unable
    // to make sense of.
    'dead_code_detection' => false,

    // Set to true in order to force tracking references to elements
    // (functions/methods/consts/protected).
    // dead_code_detection is another option which also causes references
    // to be tracked.
    'force_tracking_references' => false,

    // Run a quick version of checks that takes less
    // time
    "quick_mode" => false,

    // If true, then try to simplify AST into a form which improves Phan's type inference.
    // E.g. rewrites `if (!is_string($foo)) { return; } b($foo);`
    // into `if (is_string($foo)) {b($foo);} else {return;}`
    // This may conflict with 'dead_code_detection'
    // This slows down analysis noticeably.
    "simplify_ast" => false,

    // If true, Phan will read `class_alias` calls in the global scope,
    // then (1) create aliases from the *parsed* files if no class definition was found,
    // and (2) emit issues in the global scope if the source or target class is invalid.
    // (If there are multiple possible valid original classes for an aliased class name,
    //  the one which will be created is unspecified.)
    // NOTE: THIS IS EXPERIMENTAL, and the implementation may change.
    'enable_class_alias_support' => false,

    // Enable or disable support for generic templated
    // class types.
    'generic_types_enabled' => true,

    // Setting this to true makes the process assignment for file analysis
    // as predictable as possible, using consistent hashing.
    // Even if files are added or removed, or process counts change,
    // relatively few files will move to a different group.
    // (use when the number of files is much larger than the process count)
    // NOTE: If you rely on Phan parsing files/directories in the order
    // that they were provided in this config, don't use this)
    // See https://github.com/etsy/phan/wiki/Different-Issue-Sets-On-Different-Numbers-of-CPUs
    'consistent_hashing_file_order' => false,

    // Override to hardcode existence and types of (non-builtin) globals.
    // Class names should be prefixed with '\\'.
    // (E.g. ['_FOO' => '\\FooClass', 'page' => '\\PageClass', 'userId' => 'int'])
    'globals_type_map' => [],

    // The minimum severity level to report on. This can be
    // set to Issue::SEVERITY_LOW, Issue::SEVERITY_NORMAL or
    // Issue::SEVERITY_CRITICAL.
    'minimum_severity' => Issue::SEVERITY_LOW,

    // Add any issue types (such as 'PhanUndeclaredMethod')
    // here to inhibit them from being reported
    'suppress_issue_types' => [
        // 'PhanUndeclaredMethod',
    ],

    // If empty, no filter against issues types will be applied.
    // If non-empty, only issues within the list will be emitted
    // by Phan.
    'whitelist_issue_types' => [
        // 'PhanAccessClassConstantInternal',
        // 'PhanAccessClassConstantPrivate',
        // 'PhanAccessClassConstantProtected',
        // 'PhanAccessClassInternal',
        // 'PhanAccessConstantInternal',
        // 'PhanAccessMethodInternal',
        // 'PhanAccessMethodPrivate',
        // 'PhanAccessMethodPrivateWithCallMagicMethod',
        // 'PhanAccessMethodProtected',
        // 'PhanAccessMethodProtectedWithCallMagicMethod',
        // 'PhanAccessNonStaticToStatic',
        // 'PhanAccessOwnConstructor',
        // 'PhanAccessPropertyInternal',
        // 'PhanAccessPropertyPrivate',
        // 'PhanAccessPropertyProtected',
        // 'PhanAccessPropertyStaticAsNonStatic',
        // 'PhanAccessSignatureMismatch',
        // 'PhanAccessSignatureMismatchInternal',
        // 'PhanAccessStaticToNonStatic',
        // 'PhanClassContainsAbstractMethod',
        // 'PhanClassContainsAbstractMethodInternal',
        // 'PhanCommentParamOnEmptyParamList',
        // 'PhanCommentParamWithoutRealParam',
        // 'PhanCompatibleExpressionPHP7',
        // 'PhanCompatiblePHP7',
        // 'PhanContextNotObject',
        // 'PhanDeprecatedClass',
        // 'PhanDeprecatedFunction',
        // 'PhanDeprecatedFunctionInternal',
        // 'PhanDeprecatedInterface',
        // 'PhanDeprecatedProperty',
        // 'PhanDeprecatedTrait',
        // 'PhanEmptyFile',
        // 'PhanGenericConstructorTypes',
        // 'PhanGenericGlobalVariable',
        // 'PhanIncompatibleCompositionMethod',
        // 'PhanIncompatibleCompositionProp',
        // 'PhanInvalidCommentForDeclarationType',
        // 'PhanMismatchVariadicComment',
        // 'PhanMismatchVariadicParam',
        // 'PhanMisspelledAnnotation',
        // 'PhanNonClassMethodCall',
        // 'PhanNoopArray',
        // 'PhanNoopClosure',
        // 'PhanNoopConstant',
        // 'PhanNoopProperty',
        // 'PhanNoopVariable',
        // 'PhanParamRedefined',
        // 'PhanParamReqAfterOpt',
        // 'PhanParamSignatureMismatch',
        // 'PhanParamSignatureMismatchInternal',
        // 'PhanParamSignaturePHPDocMismatchHasNoParamType',
        // 'PhanParamSignaturePHPDocMismatchHasParamType',
        // 'PhanParamSignaturePHPDocMismatchParamIsNotReference',
        // 'PhanParamSignaturePHPDocMismatchParamIsReference',
        // 'PhanParamSignaturePHPDocMismatchParamNotVariadic',
        // 'PhanParamSignaturePHPDocMismatchParamType',
        // 'PhanParamSignaturePHPDocMismatchParamVariadic',
        // 'PhanParamSignaturePHPDocMismatchReturnType',
        // 'PhanParamSignaturePHPDocMismatchTooFewParameters',
        // 'PhanParamSignaturePHPDocMismatchTooManyRequiredParameters',
        // 'PhanParamSignatureRealMismatchHasNoParamType',
        // 'PhanParamSignatureRealMismatchHasNoParamTypeInternal',
        // 'PhanParamSignatureRealMismatchHasParamType',
        // 'PhanParamSignatureRealMismatchHasParamTypeInternal',
        // 'PhanParamSignatureRealMismatchParamIsNotReference',
        // 'PhanParamSignatureRealMismatchParamIsNotReferenceInternal',
        // 'PhanParamSignatureRealMismatchParamIsReference',
        // 'PhanParamSignatureRealMismatchParamIsReferenceInternal',
        // 'PhanParamSignatureRealMismatchParamNotVariadic',
        // 'PhanParamSignatureRealMismatchParamNotVariadicInternal',
        // 'PhanParamSignatureRealMismatchParamType',
        // 'PhanParamSignatureRealMismatchParamTypeInternal',
        // 'PhanParamSignatureRealMismatchParamVariadic',
        // 'PhanParamSignatureRealMismatchParamVariadicInternal',
        // 'PhanParamSignatureRealMismatchReturnType',
        // 'PhanParamSignatureRealMismatchReturnTypeInternal',
        // 'PhanParamSignatureRealMismatchTooFewParameters',
        // 'PhanParamSignatureRealMismatchTooFewParametersInternal',
        // 'PhanParamSignatureRealMismatchTooManyRequiredParameters',
        // 'PhanParamSignatureRealMismatchTooManyRequiredParametersInternal',
        // 'PhanParamSpecial1',
        // 'PhanParamSpecial2',
        // 'PhanParamSpecial3',
        // 'PhanParamSpecial4',
        // 'PhanParamTooFew',
        // 'PhanParamTooFewInternal',
        // 'PhanParamTooMany',
        // 'PhanParamTooManyInternal',
        // 'PhanParamTypeMismatch',
        // 'PhanParentlessClass',
        // 'PhanRedefineClass',
        // 'PhanRedefineClassAlias',
        // 'PhanRedefineClassInternal',
        // 'PhanRedefineFunction',
        // 'PhanRedefineFunctionInternal',
        // 'PhanRequiredTraitNotAdded',
        // 'PhanStaticCallToNonStatic',
        // 'PhanSyntaxError',
        // 'PhanTemplateTypeConstant',
        // 'PhanTemplateTypeStaticMethod',
        // 'PhanTemplateTypeStaticProperty',
        // 'PhanTraitParentReference',
        // 'PhanTypeArrayOperator',
        // 'PhanTypeArraySuspicious',
        // 'PhanTypeComparisonFromArray',
        // 'PhanTypeComparisonToArray',
        // 'PhanTypeConversionFromArray',
        // 'PhanTypeInstantiateAbstract',
        // 'PhanTypeInstantiateInterface',
        // 'PhanTypeInvalidClosureScope',
        // 'PhanTypeInvalidLeftOperand',
        // 'PhanTypeInvalidRightOperand',
        // 'PhanTypeMismatchArgument',
        // 'PhanTypeMismatchArgumentInternal',
        // 'PhanTypeMismatchDeclaredParam',
        // 'PhanTypeMismatchDeclaredReturn',
        // 'PhanTypeMismatchDefault',
        // 'PhanTypeMismatchForeach',
        // 'PhanTypeMismatchProperty',
        // 'PhanTypeMismatchReturn',
        // 'PhanTypeMissingReturn',
        // 'PhanTypeNonVarPassByRef',
        // 'PhanTypeParentConstructorCalled',
        // 'PhanTypeSuspiciousIndirectVariable',
        // 'PhanTypeVoidAssignment',
        // 'PhanUnanalyzable',
        // 'PhanUndeclaredAliasedMethodOfTrait',
        // 'PhanUndeclaredClass',
        // 'PhanUndeclaredClassAliasOriginal',
        // 'PhanUndeclaredClassCatch',
        // 'PhanUndeclaredClassConstant',
        // 'PhanUndeclaredClassInstanceof',
        // 'PhanUndeclaredClassMethod',
        // 'PhanUndeclaredClassReference',
        // 'PhanUndeclaredClosureScope',
        // 'PhanUndeclaredConstant',
        // 'PhanUndeclaredExtendedClass',
        // 'PhanUndeclaredFunction',
        // 'PhanUndeclaredInterface',
        // 'PhanUndeclaredMethod',
        // 'PhanUndeclaredProperty',
        // 'PhanUndeclaredStaticMethod',
        // 'PhanUndeclaredStaticProperty',
        // 'PhanUndeclaredTrait',
        // 'PhanUndeclaredTypeParameter',
        // 'PhanUndeclaredTypeProperty',
        // 'PhanUndeclaredTypeReturnType',
        // 'PhanUndeclaredVariable',
        // 'PhanUndeclaredVariableDim',
        // 'PhanUnextractableAnnotation',
        // 'PhanUnextractableAnnotationPart',
        // 'PhanUnreferencedClass',
        // 'PhanUnreferencedConstant',
        // 'PhanUnreferencedMethod',
        // 'PhanUnreferencedProperty',
        // 'PhanVariableUseClause',
    ],

    // A list of files to include in analysis
    'file_list' => [
        'bad.php',
        // 'vendor/phpunit/phpunit/src/Framework/TestCase.php',
    ],

    // A regular expression to match files to be excluded
    // from parsing and analysis and will not be read at all.
    //
    // This is useful for excluding groups of test or example
    // directories/files, unanalyzable files, or files that
    // can't be removed for whatever reason.
    // (e.g. '@Test\.php$@', or '@vendor/.*/(tests|Tests)/@')
    'exclude_file_regex' => '@^vendor/.*/(tests|Tests)/@',

    // A file list that defines files that will be excluded
    // from parsing and analysis and will not be read at all.
    //
    // This is useful for excluding hopelessly unanalyzable
    // files that can't be removed for whatever reason.
    'exclude_file_list' => [],

    // The number of processes to fork off during the analysis
    // phase.
    'processes' => 1,

    // A list of directories that should be parsed for class and
    // method information. After excluding the directories
    // defined in exclude_analysis_directory_list, the remaining
    // files will be statically analyzed for errors.
    //
    // Thus, both first-party and third-party code being used by
    // your application should be included in this list.
    'directory_list' => [
        'test',
    ],

    // List of case-insensitive file extensions supported by Phan.
    // (e.g. php, html, htm)
    'analyzed_file_extensions' => ['php'],

    // A directory list that defines files that will be excluded
    // from static analysis, but whose class and method
    // information should be included.
    //
    // Generally, you'll want to include the directories for
    // third-party code (such as "vendor/") in this list.
    //
    // n.b.: If you'd like to parse but not analyze 3rd
    //       party code, directories containing that code
    //       should be added to the `directory_list` as
    //       to `exclude_analysis_directory_list`.
    "exclude_analysis_directory_list" => [
    ],

    // By default, Phan will log error messages to stdout if PHP is using options that slow the analysis.
    // (e.g. PHP is compiled with --enable-debug or when using XDebug)
    'skip_slow_php_options_warning' => false,
];
