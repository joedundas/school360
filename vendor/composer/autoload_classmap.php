<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'AbstractDtoCollection' => $baseDir . '/app/library/Collections/Dto/AbstractDtoCollection.php',
    'AbstractFeatureDto' => $baseDir . '/app/library/Objects/Features/AbstractFeatureDto.php',
    'AbstractRepository' => $baseDir . '/app/library/Objects/AbstractRepository.php',
    'AddressValueObject' => $baseDir . '/app/library/ValueObjects/AddressValueObject.php',
    'AjaxResponseMessage' => $baseDir . '/app/library/AjaxResponseMessage.php',
    'ApiCalls' => $baseDir . '/app/models/ApiCalls.php',
    'ApiController' => $baseDir . '/app/controllers/ApiController.php',
    'AuthViewCollection' => $baseDir . '/app/library/Collections/Dto/AuthViewCollection.php',
    'AuthViewDao' => $baseDir . '/app/library/Objects/AuthView/AuthViewDao.php',
    'AuthViewDto' => $baseDir . '/app/library/Objects/AuthView/AuthViewDto.php',
    'AuthViewHydrator' => $baseDir . '/app/library/Objects/AuthView/AuthViewHydrator.php',
    'AuthViewRepository' => $baseDir . '/app/library/Objects/AuthView/AuthViewRepository.php',
    'AuthenticationController' => $baseDir . '/app/controllers/AuthenticationController.php',
    'AuthorizationController' => $baseDir . '/app/controllers/AuthorizationController.php',
    'AuthorizationDao' => $baseDir . '/app/library/Objects/Authorization/AuthorizationDao.php',
    'AuthorizationDto' => $baseDir . '/app/library/Objects/Authorization/AuthorizationDto.php',
    'AuthorizationRepository' => $baseDir . '/app/library/Objects/Authorization/AuthorizationRepository.php',
    'AuthorizationsCollection' => $baseDir . '/app/library/Collections/Dto/AuthorizationsCollection.php',
    'BaseController' => $baseDir . '/app/controllers/BaseController.php',
    'BizUtilities' => $baseDir . '/app/library/Utilities/BizUtilities.php',
    'CacheController' => $baseDir . '/app/controllers/CacheController.php',
    'CacheControllerInterface' => $baseDir . '/app/controllers/CacheControllerInterface.php',
    'CreateApiCalls' => $baseDir . '/app/database/migrations/2017_12_23_201039_create_api_calls.php',
    'CreateAuthorizationRoleDefaults' => $baseDir . '/app/database/migrations/2017_11_27_033702_create_authorization_role_defaults.php',
    'CreateAuthorizationTypes' => $baseDir . '/app/database/migrations/2017_11_24_153919_create_authorization_types.php',
    'CreateContactInfo' => $baseDir . '/app/database/migrations/2017_12_01_180412_create_contact_info.php',
    'CreateCourses' => $baseDir . '/app/database/migrations/2017_11_22_213545_create_courses.php',
    'CreateDemographics' => $baseDir . '/app/database/migrations/2017_12_01_180604_create_demographics.php',
    'CreateFeatureCodes' => $baseDir . '/app/database/migrations/2017_11_28_231950_create_feature_codes.php',
    'CreateFeatureFlips' => $baseDir . '/app/database/migrations/2017_11_28_232008_create_feature_flips.php',
    'CreateGradeLevels' => $baseDir . '/app/database/migrations/2017_11_22_213508_create_grade_levels.php',
    'CreateModalViews' => $baseDir . '/app/database/migrations/2017_11_30_023228_create_modal_views.php',
    'CreateSchoolsTable' => $baseDir . '/app/database/migrations/2017_11_19_082320_create_schools_table.php',
    'CreateUserAuthorizations' => $baseDir . '/app/database/migrations/2017_11_24_153602_create_user_authorizations.php',
    'CreateUserRelationshipMap' => $baseDir . '/app/database/migrations/2017_11_24_215130_create_user_relationship_map.php',
    'CreateUserRolesTable' => $baseDir . '/app/database/migrations/2017_11_24_214530_create_user_roles_table.php',
    'CreateUserToSchoolMapper' => $baseDir . '/app/database/migrations/2017_11_19_230028_create_user_to_school_mapper.php',
    'CreateUsersTable' => $baseDir . '/app/database/migrations/2016_11_26_223753_create_users_table.php',
    'CreateViewAuthorizations' => $baseDir . '/app/database/migrations/2017_11_27_191446_create_view_authorizations.php',
    'DatabaseSeeder' => $baseDir . '/app/database/seeds/DatabaseSeeder.php',
    'DependencyInjection' => $baseDir . '/app/library/DependencyInjection.php',
    'DtoInterface' => $baseDir . '/app/library/Objects/DtoInterface.php',
    'Edu3Sixty\\SettingsController' => $baseDir . '/app/controllers/SettingsController.php',
    'EmailValueObject' => $baseDir . '/app/library/ValueObjects/EmailValueObject.php',
    'EventDateUtilities' => $baseDir . '/app/library/Utilities/EventDateUtilities.php',
    'FeatureCodeDto' => $baseDir . '/app/library/Objects/Features/Codes/FeatureCodeDto.php',
    'FeatureCodesCollection' => $baseDir . '/app/library/Collections/Dto/FeatureCodesCollection.php',
    'FeatureDtoInterface' => $baseDir . '/app/library/Objects/Features/FeatureDtoInterface.php',
    'FeatureFlipDao' => $baseDir . '/app/library/Objects/Features/Flips/FeatureFlipDao.php',
    'FeatureFlipDto' => $baseDir . '/app/library/Objects/Features/Flips/FeatureFlipDto.php',
    'FeatureFlipHydrator' => $baseDir . '/app/library/Objects/Features/Flips/FeatureFlipHydrator.php',
    'FeatureFlipsCollection' => $baseDir . '/app/library/Collections/Dto/FeatureFlipsCollection.php',
    'FeatureRepository' => $baseDir . '/app/library/Objects/Features/FeatureRepository.php',
    'Formatter' => $baseDir . '/app/library/Utilities/Formatter.php',
    'HTMLGenerator' => $baseDir . '/app/library/CodeGenerators/HTMLGenerator.php',
    'IlluminateQueueClosure' => $vendorDir . '/laravel/framework/src/Illuminate/Queue/IlluminateQueueClosure.php',
    'ModalViewController' => $baseDir . '/app/controllers/ModalViewController.php',
    'ModalViews' => $baseDir . '/app/models/ModalViews.php',
    'Normalizer' => $vendorDir . '/patchwork/utf8/src/Normalizer.php',
    'PersonsNameValueObject' => $baseDir . '/app/library/ValueObjects/PersonsNameValueObject.php',
    'PhoneValueObject' => $baseDir . '/app/library/ValueObjects/PhoneValueObject.php',
    'RecurrenceUtilities' => $baseDir . '/app/library/Utilities/RecurrenceUtilities.php',
    'RoleCollection' => $baseDir . '/app/library/Collections/Dto/RoleCollection.php',
    'RoleDao' => $baseDir . '/app/library/Objects/Role/RoleDao.php',
    'RoleDto' => $baseDir . '/app/library/Objects/Role/RoleDto.php',
    'RoleHydrator' => $baseDir . '/app/library/Objects/Role/RoleHydrator.php',
    'RouteMapper' => $baseDir . '/app/library/Mappers/RouteMapper.php',
    'SchoolCollection' => $baseDir . '/app/library/Collections/Dto/SchoolCollection.php',
    'SchoolDao' => $baseDir . '/app/library/Objects/School/SchoolDao.php',
    'SchoolDto' => $baseDir . '/app/library/Objects/School/SchoolDto.php',
    'SchoolHydrator' => $baseDir . '/app/library/Objects/School/SchoolHydrator.php',
    'SchoolMapper' => $baseDir . '/app/library/Mappers/SchoolMapper.php',
    'SchoolRepository' => $baseDir . '/app/library/Objects/School/SchoolRepository.php',
    'SeedAuthorizationInformation' => $baseDir . '/app/database/seeds/SeedAuthorizationInformation.php',
    'SeedCourses' => $baseDir . '/app/database/seeds/SeedCourses.php',
    'SeedFeatureCodes' => $baseDir . '/app/database/seeds/SeedFeatureCodes.php',
    'SeedGradeLevels' => $baseDir . '/app/database/seeds/SeedGradeLevels.php',
    'SeedModalViews' => $baseDir . '/app/database/seeds/SeedModalViews.php',
    'SeedStatesUS' => $baseDir . '/app/database/seeds/SeedStatesUS.php',
    'SeedTestingSchool' => $baseDir . '/app/database/seeds/SeedTestingSchool.php',
    'SeedTimezones' => $baseDir . '/app/database/seeds/SeedTimezones.php',
    'SessionHandlerInterface' => $vendorDir . '/symfony/http-foundation/Resources/stubs/SessionHandlerInterface.php',
    'SessionManager' => $baseDir . '/app/library/Objects/Session/SessionManager.php',
    'TestCase' => $baseDir . '/app/tests/TestCase.php',
    'Token' => $baseDir . '/app/library/Token.php',
    'User' => $baseDir . '/app/models/User.php',
    'UserController' => $baseDir . '/app/controllers/UserController.php',
    'UserDao' => $baseDir . '/app/library/Objects/User/UserDao.php',
    'UserDto' => $baseDir . '/app/library/Objects/User/UserDto.php',
    'UserHydrator' => $baseDir . '/app/library/Objects/User/UserHydrator.php',
    'UserRepository' => $baseDir . '/app/library/Objects/User/UserRepository.php',
    'ValueObjectInterface' => $baseDir . '/app/library/ValueObjects/ValueObjectInterface.php',
    'Whoops\\Module' => $vendorDir . '/filp/whoops/src/deprecated/Zend/Module.php',
    'Whoops\\Provider\\Zend\\ExceptionStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/ExceptionStrategy.php',
    'Whoops\\Provider\\Zend\\RouteNotFoundStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/RouteNotFoundStrategy.php',
    'contactInformation' => $baseDir . '/app/library/Collections/ContactInformation.php',
    'userDemographicsDTO' => $baseDir . '/app/library/Objects/User/userDemographicsDTO.php',
);
