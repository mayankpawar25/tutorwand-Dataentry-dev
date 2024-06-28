<?php

namespace Tests\Feature;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class FastrackTest extends TestCase
{
    // use WithoutMiddleware;

    protected function setUp(): void {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * @group Assignment
     */
    public function testAssignmentWithLogin() {
        $response = $this->withSession(
            ['profile' => [
                'userId' => '107540876783757283921',
                'firstName' => 'Teacher1',
                'middleName' => '',
                'lastName' => 'WebCraft IT',
                'emailId' => 'teacher1@webcraft.co.in',
                'phoneNumber' => '',
                'userRoles' => [
                    [
                        'roleId' => '1',
                        'roleName' => 'TEACHER',
                        'description' => 'Fast track user'
                    ]
                ],        
                'profilePicUrl' => 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/s72-fbw=1/photo.jpg',
                'settings' => [
                    'assignmentFormatIds' => [
                            '42011b54-6f7e-4e4c-b359-ad7f005db0bc',
                            '8b3ce1c3-706d-4332-9664-ad6c005f1c61',
                            'dfb5c88d-9512-4eec-8a99-ad83007c0ff1',
                            'd57b90ae-f1d7-44a0-9fb0-ad8800c24725',
                            '9c8b0a78-5015-4835-9136-ad6d0051c073',
                            'eda3b85d-85ff-443d-bc8e-ad83008f3001',
                            'bb8d46ea-be2d-4302-a291-ad860060d1a3',
                            '551c9b9d-3c80-4f60-939a-ad7f0069b841',
                            '715263e2-d6f7-428e-a66a-ad8100a9dd91',
                            '11d0524d-5b04-4807-972b-ad7a00971448',
                            'a3eca3f1-f9b9-455c-a6ae-ad80005472e1',
                            'c840058f-dfe8-4004-b44f-ad7f0083cbf7',
                            '137a9180-2ec9-4f88-8fbb-ad7f008b6bd5',
                            'f347ed5e-1915-40ca-bfb1-ad8100a97719',
                            '6031d7c5-74be-455b-a9f6-ad7a0096e167',
                            '3083f8c6-4b2f-4973-be32-ad8100a863db',
                            'a7d14d26-0504-468b-91fd-ad8100a7723c',
                            'ecbc2028-a9dd-4d45-8882-ad7f008a3c94',
                            '4c5fd4a6-633d-4022-90f7-ad7f009117f9',
                            '1e0f7bec-d512-4e1f-a25a-ad7f0087920e',
                            '4a855753-96ef-4722-85fc-ad7f00831d88',
                            'da356b7a-e480-48c1-a9bc-ad7f0069c195',
                            '65855f9a-363f-49bf-b17d-ad7d00d35bdf',
                            '4ea51dd9-fb4b-4668-bdea-ad6e0073066b',
                            '1ccbf1b7-1767-4dde-aeac-ad7b0090f1b4',
                            '62a04985-b004-4350-8177-ad7c00738c4a',
                            '0f0b8191-2e89-4473-b1cd-ad72008f944b',
                            'da040a53-021e-40d2-8c69-ad74006d5b6f',
                            'c4563b0c-aaff-481f-a994-ad7900d2b331',
                            '89ad7ce0-fc1c-4549-aae1-ad7a00960e83',
                            '169f0780-80c6-445a-83b0-ad6f006b53b0',
                            'bfb5f4fd-69a0-4796-aa8e-ad7200928e4b',
                            '8109867a-1970-4c9b-9e7e-ad7300c229a5',
                            'f685d0a3-a2ff-45b9-b109-ad7500ce0347',
                            'd8c20469-9e9f-4d23-bec5-ad7500cea617',
                            '5243e2e2-aacc-48d6-ba86-ad74006feff9',
                            'a3263ccd-1b8e-4753-876b-ad7300c28648',
                            '0b821116-c324-4a1a-bc37-ad6c0058c29c',
                            '309b26c3-d2c0-4831-9797-ad6f006e68bd',
                            '64bc6316-68d8-4704-97b2-ad6f006e5850',
                            'cbca2bc7-de1e-4d40-8b47-ad6e007455f6',
                            '7e05633b-a9b2-4b01-be17-ad6e0062fd9a',
                            '64af505a-a06c-4f77-91ca-ad6e005cfd70',
                            'd4d59124-5e9e-4ed2-8ef0-ad6e004a77dd',
                            'dd738ac8-f4af-475f-a9d8-ad6d010c319d',
                            '0d6581c7-daf9-42d5-b9e1-ad6c00f1527b',
                            '5f656898-5352-481f-a16f-ad6d00a244a9',
                            'c3c97bc4-9c33-4cf3-af42-ad6d00ab2aeb',
                            'e236dcd0-31b5-4a5f-8d94-ad6d009d41f6',
                            'e4e02328-7234-4210-b7b3-ad6d009048af',
                            'd39fd495-b2b3-4103-b29d-ad6d008e2112',
                            '3b52a79d-e6ee-44e9-a70c-ad6c0058c29d',
                            '0a33e9c7-64b5-401c-a1e5-ad6c0058c29d',
                    ],
                    'isLoggedIn' => 1,
                    'board' => [
                        'id' => 'j39N8YxN',
                        'boardName' => ''
                    ],        
                    'grade' => [
                        'id' => 'xLuykOqQ',
                        'gradeName' => '',
                    ],
                    'assignmentFormatIdToSelect' => '42011b54-6f7e-4e4c-b359-ad7f005db0bc'
                ],
            ]
        ])
        ->get('assignment');
        
        $response->assertStatus(200);
        $response->assertSee('Assign');
        $response->assertSee('Topic');
        $response->assertSee('Subtopic');
    }

    /** 
     * @group Assignment
     */
    public function testAssignmentWithoutLogin() {
        $loginJSON = '{}';
        $response = $this->withSession(json_decode($loginJSON, true))->get('assignment');
        $response->assertStatus(302);
        // $response->assertUnauthorized();
    }

    /** 
     * @group General
     */
    public function testGeneralPageLoadSuccess() {
        $response = $this->withSession(
            ['profile' => [
                'userId' => '107540876783757283921',
                'firstName' => 'Teacher1',
                'middleName' => '',
                'lastName' => 'WebCraft IT',
                'emailId' => 'teacher1@webcraft.co.in',
                'phoneNumber' => '',
                'userRoles' => [
                    [
                        'roleId' => '1',
                        'roleName' => 'TEACHER',
                        'description' => 'Fast track user'
                    ]
                ],        
                'profilePicUrl' => 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/s72-fbw=1/photo.jpg',
                'settings' => [
                    'assignmentFormatIds' => [
                            '42011b54-6f7e-4e4c-b359-ad7f005db0bc',
                            '8b3ce1c3-706d-4332-9664-ad6c005f1c61',
                            'dfb5c88d-9512-4eec-8a99-ad83007c0ff1',
                            'd57b90ae-f1d7-44a0-9fb0-ad8800c24725',
                            '9c8b0a78-5015-4835-9136-ad6d0051c073',
                            'eda3b85d-85ff-443d-bc8e-ad83008f3001',
                            'bb8d46ea-be2d-4302-a291-ad860060d1a3',
                            '551c9b9d-3c80-4f60-939a-ad7f0069b841',
                            '715263e2-d6f7-428e-a66a-ad8100a9dd91',
                            '11d0524d-5b04-4807-972b-ad7a00971448',
                            'a3eca3f1-f9b9-455c-a6ae-ad80005472e1',
                            'c840058f-dfe8-4004-b44f-ad7f0083cbf7',
                            '137a9180-2ec9-4f88-8fbb-ad7f008b6bd5',
                            'f347ed5e-1915-40ca-bfb1-ad8100a97719',
                            '6031d7c5-74be-455b-a9f6-ad7a0096e167',
                            '3083f8c6-4b2f-4973-be32-ad8100a863db',
                            'a7d14d26-0504-468b-91fd-ad8100a7723c',
                            'ecbc2028-a9dd-4d45-8882-ad7f008a3c94',
                            '4c5fd4a6-633d-4022-90f7-ad7f009117f9',
                            '1e0f7bec-d512-4e1f-a25a-ad7f0087920e',
                            '4a855753-96ef-4722-85fc-ad7f00831d88',
                            'da356b7a-e480-48c1-a9bc-ad7f0069c195',
                            '65855f9a-363f-49bf-b17d-ad7d00d35bdf',
                            '4ea51dd9-fb4b-4668-bdea-ad6e0073066b',
                            '1ccbf1b7-1767-4dde-aeac-ad7b0090f1b4',
                            '62a04985-b004-4350-8177-ad7c00738c4a',
                            '0f0b8191-2e89-4473-b1cd-ad72008f944b',
                            'da040a53-021e-40d2-8c69-ad74006d5b6f',
                            'c4563b0c-aaff-481f-a994-ad7900d2b331',
                            '89ad7ce0-fc1c-4549-aae1-ad7a00960e83',
                            '169f0780-80c6-445a-83b0-ad6f006b53b0',
                            'bfb5f4fd-69a0-4796-aa8e-ad7200928e4b',
                            '8109867a-1970-4c9b-9e7e-ad7300c229a5',
                            'f685d0a3-a2ff-45b9-b109-ad7500ce0347',
                            'd8c20469-9e9f-4d23-bec5-ad7500cea617',
                            '5243e2e2-aacc-48d6-ba86-ad74006feff9',
                            'a3263ccd-1b8e-4753-876b-ad7300c28648',
                            '0b821116-c324-4a1a-bc37-ad6c0058c29c',
                            '309b26c3-d2c0-4831-9797-ad6f006e68bd',
                            '64bc6316-68d8-4704-97b2-ad6f006e5850',
                            'cbca2bc7-de1e-4d40-8b47-ad6e007455f6',
                            '7e05633b-a9b2-4b01-be17-ad6e0062fd9a',
                            '64af505a-a06c-4f77-91ca-ad6e005cfd70',
                            'd4d59124-5e9e-4ed2-8ef0-ad6e004a77dd',
                            'dd738ac8-f4af-475f-a9d8-ad6d010c319d',
                            '0d6581c7-daf9-42d5-b9e1-ad6c00f1527b',
                            '5f656898-5352-481f-a16f-ad6d00a244a9',
                            'c3c97bc4-9c33-4cf3-af42-ad6d00ab2aeb',
                            'e236dcd0-31b5-4a5f-8d94-ad6d009d41f6',
                            'e4e02328-7234-4210-b7b3-ad6d009048af',
                            'd39fd495-b2b3-4103-b29d-ad6d008e2112',
                            '3b52a79d-e6ee-44e9-a70c-ad6c0058c29d',
                            '0a33e9c7-64b5-401c-a1e5-ad6c0058c29d',
                    ],
                    'isLoggedIn' => 1,
                    'board' => [
                        'id' => 'j39N8YxN',
                        'boardName' => ''
                    ],        
                    'grade' => [
                        'id' => 'xLuykOqQ',
                        'gradeName' => '',
                    ],
                    'assignmentFormatIdToSelect' => '42011b54-6f7e-4e4c-b359-ad7f005db0bc'
                ],
            ]
        ])->get('fastrack');
        $response->assertStatus(200);
        $response->assertSee('Assessment Name');
    }

    /** 
     * @group General
     */
    public function testGeneralPageBoardSectionLoads() {
        $response = $this->withSession(
            ['profile' => [
                'userId' => '107540876783757283921',
                'firstName' => 'Teacher1',
                'middleName' => '',
                'lastName' => 'WebCraft IT',
                'emailId' => 'teacher1@webcraft.co.in',
                'phoneNumber' => '',
                'userRoles' => [
                    [
                        'roleId' => '1',
                        'roleName' => 'TEACHER',
                        'description' => 'Fast track user'
                    ]
                ],        
                'profilePicUrl' => 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/s72-fbw=1/photo.jpg',
                'settings' => [
                    'assignmentFormatIds' => [
                            '42011b54-6f7e-4e4c-b359-ad7f005db0bc',
                            '8b3ce1c3-706d-4332-9664-ad6c005f1c61',
                            'dfb5c88d-9512-4eec-8a99-ad83007c0ff1',
                            'd57b90ae-f1d7-44a0-9fb0-ad8800c24725',
                            '9c8b0a78-5015-4835-9136-ad6d0051c073',
                            'eda3b85d-85ff-443d-bc8e-ad83008f3001',
                            'bb8d46ea-be2d-4302-a291-ad860060d1a3',
                            '551c9b9d-3c80-4f60-939a-ad7f0069b841',
                            '715263e2-d6f7-428e-a66a-ad8100a9dd91',
                            '11d0524d-5b04-4807-972b-ad7a00971448',
                            'a3eca3f1-f9b9-455c-a6ae-ad80005472e1',
                            'c840058f-dfe8-4004-b44f-ad7f0083cbf7',
                            '137a9180-2ec9-4f88-8fbb-ad7f008b6bd5',
                            'f347ed5e-1915-40ca-bfb1-ad8100a97719',
                            '6031d7c5-74be-455b-a9f6-ad7a0096e167',
                            '3083f8c6-4b2f-4973-be32-ad8100a863db',
                            'a7d14d26-0504-468b-91fd-ad8100a7723c',
                            'ecbc2028-a9dd-4d45-8882-ad7f008a3c94',
                            '4c5fd4a6-633d-4022-90f7-ad7f009117f9',
                            '1e0f7bec-d512-4e1f-a25a-ad7f0087920e',
                            '4a855753-96ef-4722-85fc-ad7f00831d88',
                            'da356b7a-e480-48c1-a9bc-ad7f0069c195',
                            '65855f9a-363f-49bf-b17d-ad7d00d35bdf',
                            '4ea51dd9-fb4b-4668-bdea-ad6e0073066b',
                            '1ccbf1b7-1767-4dde-aeac-ad7b0090f1b4',
                            '62a04985-b004-4350-8177-ad7c00738c4a',
                            '0f0b8191-2e89-4473-b1cd-ad72008f944b',
                            'da040a53-021e-40d2-8c69-ad74006d5b6f',
                            'c4563b0c-aaff-481f-a994-ad7900d2b331',
                            '89ad7ce0-fc1c-4549-aae1-ad7a00960e83',
                            '169f0780-80c6-445a-83b0-ad6f006b53b0',
                            'bfb5f4fd-69a0-4796-aa8e-ad7200928e4b',
                            '8109867a-1970-4c9b-9e7e-ad7300c229a5',
                            'f685d0a3-a2ff-45b9-b109-ad7500ce0347',
                            'd8c20469-9e9f-4d23-bec5-ad7500cea617',
                            '5243e2e2-aacc-48d6-ba86-ad74006feff9',
                            'a3263ccd-1b8e-4753-876b-ad7300c28648',
                            '0b821116-c324-4a1a-bc37-ad6c0058c29c',
                            '309b26c3-d2c0-4831-9797-ad6f006e68bd',
                            '64bc6316-68d8-4704-97b2-ad6f006e5850',
                            'cbca2bc7-de1e-4d40-8b47-ad6e007455f6',
                            '7e05633b-a9b2-4b01-be17-ad6e0062fd9a',
                            '64af505a-a06c-4f77-91ca-ad6e005cfd70',
                            'd4d59124-5e9e-4ed2-8ef0-ad6e004a77dd',
                            'dd738ac8-f4af-475f-a9d8-ad6d010c319d',
                            '0d6581c7-daf9-42d5-b9e1-ad6c00f1527b',
                            '5f656898-5352-481f-a16f-ad6d00a244a9',
                            'c3c97bc4-9c33-4cf3-af42-ad6d00ab2aeb',
                            'e236dcd0-31b5-4a5f-8d94-ad6d009d41f6',
                            'e4e02328-7234-4210-b7b3-ad6d009048af',
                            'd39fd495-b2b3-4103-b29d-ad6d008e2112',
                            '3b52a79d-e6ee-44e9-a70c-ad6c0058c29d',
                            '0a33e9c7-64b5-401c-a1e5-ad6c0058c29d',
                    ],
                    'isLoggedIn' => 1,
                    'board' => [
                        'id' => 'j39N8YxN',
                        'boardName' => ''
                    ],        
                    'grade' => [
                        'id' => 'xLuykOqQ',
                        'gradeName' => '',
                    ],
                    'assignmentFormatIdToSelect' => '42011b54-6f7e-4e4c-b359-ad7f005db0bc'
                ],
            ]
        ])->get('get/select/panel');
        $response->assertStatus(200);
        $response->assertSee('Subject');
    }

    /**
     * @group General
     */
    public function testGeneralTemplateSectionLoads() {
        $response = $this->withSession(
            ['profile' => [
                'userId' => '107540876783757283921',
                'firstName' => 'Teacher1',
                'middleName' => '',
                'lastName' => 'WebCraft IT',
                'emailId' => 'teacher1@webcraft.co.in',
                'phoneNumber' => '',
                'userRoles' => [
                    [
                        'roleId' => '1',
                        'roleName' => 'TEACHER',
                        'description' => 'Fast track user'
                    ]
                ],        
                'profilePicUrl' => 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/s72-fbw=1/photo.jpg',
                'settings' => [
                    'assignmentFormatIds' => [
                            '42011b54-6f7e-4e4c-b359-ad7f005db0bc',
                            '8b3ce1c3-706d-4332-9664-ad6c005f1c61',
                            'dfb5c88d-9512-4eec-8a99-ad83007c0ff1',
                            'd57b90ae-f1d7-44a0-9fb0-ad8800c24725',
                            '9c8b0a78-5015-4835-9136-ad6d0051c073',
                            'eda3b85d-85ff-443d-bc8e-ad83008f3001',
                            'bb8d46ea-be2d-4302-a291-ad860060d1a3',
                            '551c9b9d-3c80-4f60-939a-ad7f0069b841',
                            '715263e2-d6f7-428e-a66a-ad8100a9dd91',
                            '11d0524d-5b04-4807-972b-ad7a00971448',
                            'a3eca3f1-f9b9-455c-a6ae-ad80005472e1',
                            'c840058f-dfe8-4004-b44f-ad7f0083cbf7',
                            '137a9180-2ec9-4f88-8fbb-ad7f008b6bd5',
                            'f347ed5e-1915-40ca-bfb1-ad8100a97719',
                            '6031d7c5-74be-455b-a9f6-ad7a0096e167',
                            '3083f8c6-4b2f-4973-be32-ad8100a863db',
                            'a7d14d26-0504-468b-91fd-ad8100a7723c',
                            'ecbc2028-a9dd-4d45-8882-ad7f008a3c94',
                            '4c5fd4a6-633d-4022-90f7-ad7f009117f9',
                            '1e0f7bec-d512-4e1f-a25a-ad7f0087920e',
                            '4a855753-96ef-4722-85fc-ad7f00831d88',
                            'da356b7a-e480-48c1-a9bc-ad7f0069c195',
                            '65855f9a-363f-49bf-b17d-ad7d00d35bdf',
                            '4ea51dd9-fb4b-4668-bdea-ad6e0073066b',
                            '1ccbf1b7-1767-4dde-aeac-ad7b0090f1b4',
                            '62a04985-b004-4350-8177-ad7c00738c4a',
                            '0f0b8191-2e89-4473-b1cd-ad72008f944b',
                            'da040a53-021e-40d2-8c69-ad74006d5b6f',
                            'c4563b0c-aaff-481f-a994-ad7900d2b331',
                            '89ad7ce0-fc1c-4549-aae1-ad7a00960e83',
                            '169f0780-80c6-445a-83b0-ad6f006b53b0',
                            'bfb5f4fd-69a0-4796-aa8e-ad7200928e4b',
                            '8109867a-1970-4c9b-9e7e-ad7300c229a5',
                            'f685d0a3-a2ff-45b9-b109-ad7500ce0347',
                            'd8c20469-9e9f-4d23-bec5-ad7500cea617',
                            '5243e2e2-aacc-48d6-ba86-ad74006feff9',
                            'a3263ccd-1b8e-4753-876b-ad7300c28648',
                            '0b821116-c324-4a1a-bc37-ad6c0058c29c',
                            '309b26c3-d2c0-4831-9797-ad6f006e68bd',
                            '64bc6316-68d8-4704-97b2-ad6f006e5850',
                            'cbca2bc7-de1e-4d40-8b47-ad6e007455f6',
                            '7e05633b-a9b2-4b01-be17-ad6e0062fd9a',
                            '64af505a-a06c-4f77-91ca-ad6e005cfd70',
                            'd4d59124-5e9e-4ed2-8ef0-ad6e004a77dd',
                            'dd738ac8-f4af-475f-a9d8-ad6d010c319d',
                            '0d6581c7-daf9-42d5-b9e1-ad6c00f1527b',
                            '5f656898-5352-481f-a16f-ad6d00a244a9',
                            'c3c97bc4-9c33-4cf3-af42-ad6d00ab2aeb',
                            'e236dcd0-31b5-4a5f-8d94-ad6d009d41f6',
                            'e4e02328-7234-4210-b7b3-ad6d009048af',
                            'd39fd495-b2b3-4103-b29d-ad6d008e2112',
                            '3b52a79d-e6ee-44e9-a70c-ad6c0058c29d',
                            '0a33e9c7-64b5-401c-a1e5-ad6c0058c29d',
                    ],
                    'isLoggedIn' => 1,
                    'board' => [
                        'id' => 'j39N8YxN',
                        'boardName' => ''
                    ],        
                    'grade' => [
                        'id' => 'xLuykOqQ',
                        'gradeName' => '',
                    ],
                    'assignmentFormatIdToSelect' => '42011b54-6f7e-4e4c-b359-ad7f005db0bc'
                ],
            ]
        ])->get('get/my/templates');
        $response->assertStatus(200);
        $response->assertSee('Points');
    }

    /**
     * @group Review
     */
    public function testQuestionsLoadSucces() {
        $loginJSON = '{"profile":{"userId":"107540876783757283921","firstName":"Teacher1","middleName":"","lastName":"WebCraft IT","emailId":"teacher1@webcraft.co.in","phoneNumber":"","userRoles":[{"roleId":"1","roleName":"TEACHER","description":"Fast track user"}],"profilePicUrl":"https:\/\/lh3.googleusercontent.com\/-XdUIqdMkCWA\/AAAAAAAAAAI\/AAAAAAAAAAA\/4252rscbv5M\/s72-fbw=1\/photo.jpg","settings":{"assignmentFormatIds":["42011b54-6f7e-4e4c-b359-ad7f005db0bc","8b3ce1c3-706d-4332-9664-ad6c005f1c61","dfb5c88d-9512-4eec-8a99-ad83007c0ff1","d57b90ae-f1d7-44a0-9fb0-ad8800c24725","9c8b0a78-5015-4835-9136-ad6d0051c073","eda3b85d-85ff-443d-bc8e-ad83008f3001","bb8d46ea-be2d-4302-a291-ad860060d1a3","551c9b9d-3c80-4f60-939a-ad7f0069b841","715263e2-d6f7-428e-a66a-ad8100a9dd91","11d0524d-5b04-4807-972b-ad7a00971448","a3eca3f1-f9b9-455c-a6ae-ad80005472e1","c840058f-dfe8-4004-b44f-ad7f0083cbf7","137a9180-2ec9-4f88-8fbb-ad7f008b6bd5","f347ed5e-1915-40ca-bfb1-ad8100a97719","6031d7c5-74be-455b-a9f6-ad7a0096e167","3083f8c6-4b2f-4973-be32-ad8100a863db","a7d14d26-0504-468b-91fd-ad8100a7723c","ecbc2028-a9dd-4d45-8882-ad7f008a3c94","4c5fd4a6-633d-4022-90f7-ad7f009117f9","1e0f7bec-d512-4e1f-a25a-ad7f0087920e","4a855753-96ef-4722-85fc-ad7f00831d88","da356b7a-e480-48c1-a9bc-ad7f0069c195","65855f9a-363f-49bf-b17d-ad7d00d35bdf","4ea51dd9-fb4b-4668-bdea-ad6e0073066b","1ccbf1b7-1767-4dde-aeac-ad7b0090f1b4","62a04985-b004-4350-8177-ad7c00738c4a","0f0b8191-2e89-4473-b1cd-ad72008f944b","da040a53-021e-40d2-8c69-ad74006d5b6f","c4563b0c-aaff-481f-a994-ad7900d2b331","89ad7ce0-fc1c-4549-aae1-ad7a00960e83","169f0780-80c6-445a-83b0-ad6f006b53b0","bfb5f4fd-69a0-4796-aa8e-ad7200928e4b","8109867a-1970-4c9b-9e7e-ad7300c229a5","f685d0a3-a2ff-45b9-b109-ad7500ce0347","d8c20469-9e9f-4d23-bec5-ad7500cea617","5243e2e2-aacc-48d6-ba86-ad74006feff9","a3263ccd-1b8e-4753-876b-ad7300c28648","0b821116-c324-4a1a-bc37-ad6c0058c29c","309b26c3-d2c0-4831-9797-ad6f006e68bd","64bc6316-68d8-4704-97b2-ad6f006e5850","cbca2bc7-de1e-4d40-8b47-ad6e007455f6","7e05633b-a9b2-4b01-be17-ad6e0062fd9a","64af505a-a06c-4f77-91ca-ad6e005cfd70","d4d59124-5e9e-4ed2-8ef0-ad6e004a77dd","dd738ac8-f4af-475f-a9d8-ad6d010c319d","0d6581c7-daf9-42d5-b9e1-ad6c00f1527b","5f656898-5352-481f-a16f-ad6d00a244a9","c3c97bc4-9c33-4cf3-af42-ad6d00ab2aeb","e236dcd0-31b5-4a5f-8d94-ad6d009d41f6","e4e02328-7234-4210-b7b3-ad6d009048af","d39fd495-b2b3-4103-b29d-ad6d008e2112","3b52a79d-e6ee-44e9-a70c-ad6c0058c29d","0a33e9c7-64b5-401c-a1e5-ad6c0058c29d"],"isLoggedIn":1,"board":{"id":"j39N8YxN","boardName":""},"grade":{"id":"xLuykOqQ","gradeName":""},"assignmentFormatIdToSelect":"42011b54-6f7e-4e4c-b359-ad7f005db0bc"}}}';
        $requestJSON = '{"data":{"id":"33b88170-998c-49e8-823f-ad8d00d766d2","ownerId":"107540876783757283921","formatName":"Test Date","inputTitle":"test","selectBoard":"j39N8YxN","selectSubject":"VOTBhxSi","selectGrade":"xLuykOqQ","selectTopic":"0IVvoKAa,muJaltt4,LhIYwxBw,gLxYFCk1,3zlldJn4,Ot0NkJwg,UAfdxiWI,rTmjIqDb,8H9Kv4iT,92tOXzNw,8mi61iyU,5eeZKnkb,GgNrrVoK,Hj3wTZ6L,09kn2nwP","selectSubTopic":"06CBNF4L,Qfa5NJmc,Iayi7OKZ,cAgb10iS,JBqVjbuW,Lni5YBH3,9nBXdezY,LuqNHA7i,p7ZxR8QP,T8aLX78l,ed38gxph,BYwhtZYb,5i9s3f8D,8NqYit8o,76D8EGQQ,VXK10szs,TPw8Wvk4,5bJIPuXQ,qLnP3Hlf,7NFiYx20,YQelHCLf,ZTDnNngH,Kk3jr6Q2,azMxdM5v,8QkrGr9U,ZSMhSNnh,sftyOOmJ,iqedqjLn,06KT6jVE,UQwtyZbC,gx2Jn74q,O6nOunks,DHCxs73b,a6TkgV97,s9cotAQe,k4j1RRQH,JnLcVrim,hzMY9CaF,Wj8Y6UhF,cGCQOXtV,LbUQ5uGG,NRu5weMC,eDDD77W1,4jcP7kzN,Apeju6dc,DRa2jNh4,BwZX8Ywm,MyXj1pfi,VhyjXZIz,LuJ36LHA,MKszSplv,qEASqiUr,lFlyWjgm,tvVnJ261,XP9iH46d,nYgofgxE,Nrbcr9LC,MpwYygw3,Ng4Visib,orMdR8g8,n1zqk05C,XEHLtPPA,EGpGB9r6,Skb6F3JQ,x5dfTL78,oPyfJ90y,h1qvI8kI,7uravItI,mugy7ScF,LHTkbkhg,YEmz9wfZ,20KggkAw,zvTTU2NB,NBeIv2GV,rkBGw89V,vOcdVuSC,E2dEVy9S,YY25opim,JIKI8wxa,jObt3Jft,l3XB6XEm,g1Z0SfzS,cZ8hvMBs,6jW0935Z,UDIyMQok,y7FmbdPi,tTUJEw3H,ceoOqYhJ,K6p9Jt6C,vv5Fc6Kk,IjLTZ024,tL5DUR04,WgSjgoBm,O75UzSho,rM3hQNRW,Dr6EViDM,wwx1uoVg,RpMhYQIl,QDZKQNgy,6acQhlgi","selectedTemplateId":"33b88170-998c-49e8-823f-ad8d00d766d2","selectedTemplateType":"undefined","difficultyLevel":"3","questionBank":"TutorWand","previousYear":"undefined","isModified":"0","isSkip":"false"},"_token":"WMmRwSxuS3ng1ioSCsERhxYJfZ1q0LiW68o0bIUA","newPaper":"true"}';
        $response = $this->withSession(json_decode($loginJSON, true))
                        ->post('questionreview', json_decode($requestJSON, true));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(['Pts.'], true);

    }

    /**
     * @group Review
     */
    public function testQuestionsLoadNoQuestions() {
        $loginJSON = '{"profile":{"userId":"107540876783757283921","firstName":"Teacher1","middleName":"","lastName":"WebCraft IT","emailId":"teacher1@webcraft.co.in","phoneNumber":"","userRoles":[{"roleId":"1","roleName":"TEACHER","description":"Fast track user"}],"profilePicUrl":"https:\/\/lh3.googleusercontent.com\/-XdUIqdMkCWA\/AAAAAAAAAAI\/AAAAAAAAAAA\/4252rscbv5M\/s72-fbw=1\/photo.jpg","settings":{"assignmentFormatIds":["42011b54-6f7e-4e4c-b359-ad7f005db0bc","8b3ce1c3-706d-4332-9664-ad6c005f1c61","dfb5c88d-9512-4eec-8a99-ad83007c0ff1","d57b90ae-f1d7-44a0-9fb0-ad8800c24725","9c8b0a78-5015-4835-9136-ad6d0051c073","eda3b85d-85ff-443d-bc8e-ad83008f3001","bb8d46ea-be2d-4302-a291-ad860060d1a3","551c9b9d-3c80-4f60-939a-ad7f0069b841","715263e2-d6f7-428e-a66a-ad8100a9dd91","11d0524d-5b04-4807-972b-ad7a00971448","a3eca3f1-f9b9-455c-a6ae-ad80005472e1","c840058f-dfe8-4004-b44f-ad7f0083cbf7","137a9180-2ec9-4f88-8fbb-ad7f008b6bd5","f347ed5e-1915-40ca-bfb1-ad8100a97719","6031d7c5-74be-455b-a9f6-ad7a0096e167","3083f8c6-4b2f-4973-be32-ad8100a863db","a7d14d26-0504-468b-91fd-ad8100a7723c","ecbc2028-a9dd-4d45-8882-ad7f008a3c94","4c5fd4a6-633d-4022-90f7-ad7f009117f9","1e0f7bec-d512-4e1f-a25a-ad7f0087920e","4a855753-96ef-4722-85fc-ad7f00831d88","da356b7a-e480-48c1-a9bc-ad7f0069c195","65855f9a-363f-49bf-b17d-ad7d00d35bdf","4ea51dd9-fb4b-4668-bdea-ad6e0073066b","1ccbf1b7-1767-4dde-aeac-ad7b0090f1b4","62a04985-b004-4350-8177-ad7c00738c4a","0f0b8191-2e89-4473-b1cd-ad72008f944b","da040a53-021e-40d2-8c69-ad74006d5b6f","c4563b0c-aaff-481f-a994-ad7900d2b331","89ad7ce0-fc1c-4549-aae1-ad7a00960e83","169f0780-80c6-445a-83b0-ad6f006b53b0","bfb5f4fd-69a0-4796-aa8e-ad7200928e4b","8109867a-1970-4c9b-9e7e-ad7300c229a5","f685d0a3-a2ff-45b9-b109-ad7500ce0347","d8c20469-9e9f-4d23-bec5-ad7500cea617","5243e2e2-aacc-48d6-ba86-ad74006feff9","a3263ccd-1b8e-4753-876b-ad7300c28648","0b821116-c324-4a1a-bc37-ad6c0058c29c","309b26c3-d2c0-4831-9797-ad6f006e68bd","64bc6316-68d8-4704-97b2-ad6f006e5850","cbca2bc7-de1e-4d40-8b47-ad6e007455f6","7e05633b-a9b2-4b01-be17-ad6e0062fd9a","64af505a-a06c-4f77-91ca-ad6e005cfd70","d4d59124-5e9e-4ed2-8ef0-ad6e004a77dd","dd738ac8-f4af-475f-a9d8-ad6d010c319d","0d6581c7-daf9-42d5-b9e1-ad6c00f1527b","5f656898-5352-481f-a16f-ad6d00a244a9","c3c97bc4-9c33-4cf3-af42-ad6d00ab2aeb","e236dcd0-31b5-4a5f-8d94-ad6d009d41f6","e4e02328-7234-4210-b7b3-ad6d009048af","d39fd495-b2b3-4103-b29d-ad6d008e2112","3b52a79d-e6ee-44e9-a70c-ad6c0058c29d","0a33e9c7-64b5-401c-a1e5-ad6c0058c29d"],"isLoggedIn":1,"board":{"id":"j39N8YxN","boardName":""},"grade":{"id":"xLuykOqQ","gradeName":""},"assignmentFormatIdToSelect":"42011b54-6f7e-4e4c-b359-ad7f005db0bc"}}}';
        $requestJSON = '{"data":{"id":"33b88170-998c-49e8-823f-ad8d00d766d2","ownerId":"107540876783757283921","formatName":"Test Date","inputTitle":"test","selectBoard":"j39N8YxN","selectSubject":"kf6mS1HM","selectGrade":"mmFKhGlr","selectTopic":"f5rCKKqa","selectSubTopic":"0O3Qusg0,1YNXolP8","selectedTemplateId":"33b88170-998c-49e8-823f-ad8d00d766d2","selectedTemplateType":"undefined","difficultyLevel":"3","questionBank":"TutorWand","previousYear":"undefined","isModified":"0","isSkip":"false"},"_token":"WMmRwSxuS3ng1ioSCsERhxYJfZ1q0LiW68o0bIUA","newPaper":"true"}';
        $response = $this->withSession(json_decode($loginJSON, true))
                        ->post('questionreview', json_decode($requestJSON, true));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(['Multi choice', 'True or false'], true);
    }
    
    /**
     * @group Review
     */
    public function testQuestionsLoadFailIfBlankRequest() {
        $this->withExceptionHandling();
        $loginJSON = '{"profile":{"userId":"107540876783757283921","firstName":"Teacher1","middleName":"","lastName":"WebCraft IT","emailId":"teacher1@webcraft.co.in","phoneNumber":"","userRoles":[{"roleId":"1","roleName":"TEACHER","description":"Fast track user"}],"profilePicUrl":"https:\/\/lh3.googleusercontent.com\/-XdUIqdMkCWA\/AAAAAAAAAAI\/AAAAAAAAAAA\/4252rscbv5M\/s72-fbw=1\/photo.jpg","settings":{"assignmentFormatIds":["42011b54-6f7e-4e4c-b359-ad7f005db0bc","8b3ce1c3-706d-4332-9664-ad6c005f1c61","dfb5c88d-9512-4eec-8a99-ad83007c0ff1","d57b90ae-f1d7-44a0-9fb0-ad8800c24725","9c8b0a78-5015-4835-9136-ad6d0051c073","eda3b85d-85ff-443d-bc8e-ad83008f3001","bb8d46ea-be2d-4302-a291-ad860060d1a3","551c9b9d-3c80-4f60-939a-ad7f0069b841","715263e2-d6f7-428e-a66a-ad8100a9dd91","11d0524d-5b04-4807-972b-ad7a00971448","a3eca3f1-f9b9-455c-a6ae-ad80005472e1","c840058f-dfe8-4004-b44f-ad7f0083cbf7","137a9180-2ec9-4f88-8fbb-ad7f008b6bd5","f347ed5e-1915-40ca-bfb1-ad8100a97719","6031d7c5-74be-455b-a9f6-ad7a0096e167","3083f8c6-4b2f-4973-be32-ad8100a863db","a7d14d26-0504-468b-91fd-ad8100a7723c","ecbc2028-a9dd-4d45-8882-ad7f008a3c94","4c5fd4a6-633d-4022-90f7-ad7f009117f9","1e0f7bec-d512-4e1f-a25a-ad7f0087920e","4a855753-96ef-4722-85fc-ad7f00831d88","da356b7a-e480-48c1-a9bc-ad7f0069c195","65855f9a-363f-49bf-b17d-ad7d00d35bdf","4ea51dd9-fb4b-4668-bdea-ad6e0073066b","1ccbf1b7-1767-4dde-aeac-ad7b0090f1b4","62a04985-b004-4350-8177-ad7c00738c4a","0f0b8191-2e89-4473-b1cd-ad72008f944b","da040a53-021e-40d2-8c69-ad74006d5b6f","c4563b0c-aaff-481f-a994-ad7900d2b331","89ad7ce0-fc1c-4549-aae1-ad7a00960e83","169f0780-80c6-445a-83b0-ad6f006b53b0","bfb5f4fd-69a0-4796-aa8e-ad7200928e4b","8109867a-1970-4c9b-9e7e-ad7300c229a5","f685d0a3-a2ff-45b9-b109-ad7500ce0347","d8c20469-9e9f-4d23-bec5-ad7500cea617","5243e2e2-aacc-48d6-ba86-ad74006feff9","a3263ccd-1b8e-4753-876b-ad7300c28648","0b821116-c324-4a1a-bc37-ad6c0058c29c","309b26c3-d2c0-4831-9797-ad6f006e68bd","64bc6316-68d8-4704-97b2-ad6f006e5850","cbca2bc7-de1e-4d40-8b47-ad6e007455f6","7e05633b-a9b2-4b01-be17-ad6e0062fd9a","64af505a-a06c-4f77-91ca-ad6e005cfd70","d4d59124-5e9e-4ed2-8ef0-ad6e004a77dd","dd738ac8-f4af-475f-a9d8-ad6d010c319d","0d6581c7-daf9-42d5-b9e1-ad6c00f1527b","5f656898-5352-481f-a16f-ad6d00a244a9","c3c97bc4-9c33-4cf3-af42-ad6d00ab2aeb","e236dcd0-31b5-4a5f-8d94-ad6d009d41f6","e4e02328-7234-4210-b7b3-ad6d009048af","d39fd495-b2b3-4103-b29d-ad6d008e2112","3b52a79d-e6ee-44e9-a70c-ad6c0058c29d","0a33e9c7-64b5-401c-a1e5-ad6c0058c29d"],"isLoggedIn":1,"board":{"id":"j39N8YxN","boardName":""},"grade":{"id":"xLuykOqQ","gradeName":""},"assignmentFormatIdToSelect":"42011b54-6f7e-4e4c-b359-ad7f005db0bc"}}}';
        $requestJSON = '{}';
        $response = $this->withSession(json_decode($loginJSON, true))
                        ->post('questionreview', json_decode($requestJSON, true));
        $response->assertStatus(500);
    }

    /**
     * @group ReviewSwap
     */
    public function testReviewSwapQuestion() {
        $loginJSON = '{"profile":{"userId":"107540876783757283921","firstName":"Teacher1","middleName":"","lastName":"WebCraft IT","emailId":"teacher1@webcraft.co.in","phoneNumber":"","userRoles":[{"roleId":"1","roleName":"TEACHER","description":"Fast track user"}],"profilePicUrl":"https:\/\/lh3.googleusercontent.com\/-XdUIqdMkCWA\/AAAAAAAAAAI\/AAAAAAAAAAA\/4252rscbv5M\/s72-fbw=1\/photo.jpg","settings":{"assignmentFormatIds":["42011b54-6f7e-4e4c-b359-ad7f005db0bc","8b3ce1c3-706d-4332-9664-ad6c005f1c61","dfb5c88d-9512-4eec-8a99-ad83007c0ff1","d57b90ae-f1d7-44a0-9fb0-ad8800c24725","9c8b0a78-5015-4835-9136-ad6d0051c073","eda3b85d-85ff-443d-bc8e-ad83008f3001","bb8d46ea-be2d-4302-a291-ad860060d1a3","551c9b9d-3c80-4f60-939a-ad7f0069b841","715263e2-d6f7-428e-a66a-ad8100a9dd91","11d0524d-5b04-4807-972b-ad7a00971448","a3eca3f1-f9b9-455c-a6ae-ad80005472e1","c840058f-dfe8-4004-b44f-ad7f0083cbf7","137a9180-2ec9-4f88-8fbb-ad7f008b6bd5","f347ed5e-1915-40ca-bfb1-ad8100a97719","6031d7c5-74be-455b-a9f6-ad7a0096e167","3083f8c6-4b2f-4973-be32-ad8100a863db","a7d14d26-0504-468b-91fd-ad8100a7723c","ecbc2028-a9dd-4d45-8882-ad7f008a3c94","4c5fd4a6-633d-4022-90f7-ad7f009117f9","1e0f7bec-d512-4e1f-a25a-ad7f0087920e","4a855753-96ef-4722-85fc-ad7f00831d88","da356b7a-e480-48c1-a9bc-ad7f0069c195","65855f9a-363f-49bf-b17d-ad7d00d35bdf","4ea51dd9-fb4b-4668-bdea-ad6e0073066b","1ccbf1b7-1767-4dde-aeac-ad7b0090f1b4","62a04985-b004-4350-8177-ad7c00738c4a","0f0b8191-2e89-4473-b1cd-ad72008f944b","da040a53-021e-40d2-8c69-ad74006d5b6f","c4563b0c-aaff-481f-a994-ad7900d2b331","89ad7ce0-fc1c-4549-aae1-ad7a00960e83","169f0780-80c6-445a-83b0-ad6f006b53b0","bfb5f4fd-69a0-4796-aa8e-ad7200928e4b","8109867a-1970-4c9b-9e7e-ad7300c229a5","f685d0a3-a2ff-45b9-b109-ad7500ce0347","d8c20469-9e9f-4d23-bec5-ad7500cea617","5243e2e2-aacc-48d6-ba86-ad74006feff9","a3263ccd-1b8e-4753-876b-ad7300c28648","0b821116-c324-4a1a-bc37-ad6c0058c29c","309b26c3-d2c0-4831-9797-ad6f006e68bd","64bc6316-68d8-4704-97b2-ad6f006e5850","cbca2bc7-de1e-4d40-8b47-ad6e007455f6","7e05633b-a9b2-4b01-be17-ad6e0062fd9a","64af505a-a06c-4f77-91ca-ad6e005cfd70","d4d59124-5e9e-4ed2-8ef0-ad6e004a77dd","dd738ac8-f4af-475f-a9d8-ad6d010c319d","0d6581c7-daf9-42d5-b9e1-ad6c00f1527b","5f656898-5352-481f-a16f-ad6d00a244a9","c3c97bc4-9c33-4cf3-af42-ad6d00ab2aeb","e236dcd0-31b5-4a5f-8d94-ad6d009d41f6","e4e02328-7234-4210-b7b3-ad6d009048af","d39fd495-b2b3-4103-b29d-ad6d008e2112","3b52a79d-e6ee-44e9-a70c-ad6c0058c29d","0a33e9c7-64b5-401c-a1e5-ad6c0058c29d"],"isLoggedIn":1,"board":{"id":"j39N8YxN","boardName":""},"grade":{"id":"xLuykOqQ","gradeName":""},"assignmentFormatIdToSelect":"42011b54-6f7e-4e4c-b359-ad7f005db0bc"}}}';
        $requestData = 'id=366fb172-e6cc-46e3-8cc2-ad5e00a925a9&paperId=b225dff5-cd40-4617-b907-ad8e0093d207&questionNumber=1';
        $response = $this->withSession(json_decode($loginJSON, true))
                        ->get('get/question/swap?'.$requestData);
        // dd($response->getContent());
        $response->assertStatus(200);
    }

    /**
     * @group ReviewPreview
     */
    public function testReviewPreviewQuestion() {
        $loginJSON = '{"profile":{"userId":"107540876783757283921","firstName":"Teacher1","middleName":"","lastName":"WebCraft IT","emailId":"teacher1@webcraft.co.in","phoneNumber":"","userRoles":[{"roleId":"1","roleName":"TEACHER","description":"Fast track user"}],"profilePicUrl":"https:\/\/lh3.googleusercontent.com\/-XdUIqdMkCWA\/AAAAAAAAAAI\/AAAAAAAAAAA\/4252rscbv5M\/s72-fbw=1\/photo.jpg","settings":{"assignmentFormatIds":["42011b54-6f7e-4e4c-b359-ad7f005db0bc","8b3ce1c3-706d-4332-9664-ad6c005f1c61","dfb5c88d-9512-4eec-8a99-ad83007c0ff1","d57b90ae-f1d7-44a0-9fb0-ad8800c24725","9c8b0a78-5015-4835-9136-ad6d0051c073","eda3b85d-85ff-443d-bc8e-ad83008f3001","bb8d46ea-be2d-4302-a291-ad860060d1a3","551c9b9d-3c80-4f60-939a-ad7f0069b841","715263e2-d6f7-428e-a66a-ad8100a9dd91","11d0524d-5b04-4807-972b-ad7a00971448","a3eca3f1-f9b9-455c-a6ae-ad80005472e1","c840058f-dfe8-4004-b44f-ad7f0083cbf7","137a9180-2ec9-4f88-8fbb-ad7f008b6bd5","f347ed5e-1915-40ca-bfb1-ad8100a97719","6031d7c5-74be-455b-a9f6-ad7a0096e167","3083f8c6-4b2f-4973-be32-ad8100a863db","a7d14d26-0504-468b-91fd-ad8100a7723c","ecbc2028-a9dd-4d45-8882-ad7f008a3c94","4c5fd4a6-633d-4022-90f7-ad7f009117f9","1e0f7bec-d512-4e1f-a25a-ad7f0087920e","4a855753-96ef-4722-85fc-ad7f00831d88","da356b7a-e480-48c1-a9bc-ad7f0069c195","65855f9a-363f-49bf-b17d-ad7d00d35bdf","4ea51dd9-fb4b-4668-bdea-ad6e0073066b","1ccbf1b7-1767-4dde-aeac-ad7b0090f1b4","62a04985-b004-4350-8177-ad7c00738c4a","0f0b8191-2e89-4473-b1cd-ad72008f944b","da040a53-021e-40d2-8c69-ad74006d5b6f","c4563b0c-aaff-481f-a994-ad7900d2b331","89ad7ce0-fc1c-4549-aae1-ad7a00960e83","169f0780-80c6-445a-83b0-ad6f006b53b0","bfb5f4fd-69a0-4796-aa8e-ad7200928e4b","8109867a-1970-4c9b-9e7e-ad7300c229a5","f685d0a3-a2ff-45b9-b109-ad7500ce0347","d8c20469-9e9f-4d23-bec5-ad7500cea617","5243e2e2-aacc-48d6-ba86-ad74006feff9","a3263ccd-1b8e-4753-876b-ad7300c28648","0b821116-c324-4a1a-bc37-ad6c0058c29c","309b26c3-d2c0-4831-9797-ad6f006e68bd","64bc6316-68d8-4704-97b2-ad6f006e5850","cbca2bc7-de1e-4d40-8b47-ad6e007455f6","7e05633b-a9b2-4b01-be17-ad6e0062fd9a","64af505a-a06c-4f77-91ca-ad6e005cfd70","d4d59124-5e9e-4ed2-8ef0-ad6e004a77dd","dd738ac8-f4af-475f-a9d8-ad6d010c319d","0d6581c7-daf9-42d5-b9e1-ad6c00f1527b","5f656898-5352-481f-a16f-ad6d00a244a9","c3c97bc4-9c33-4cf3-af42-ad6d00ab2aeb","e236dcd0-31b5-4a5f-8d94-ad6d009d41f6","e4e02328-7234-4210-b7b3-ad6d009048af","d39fd495-b2b3-4103-b29d-ad6d008e2112","3b52a79d-e6ee-44e9-a70c-ad6c0058c29d","0a33e9c7-64b5-401c-a1e5-ad6c0058c29d"],"isLoggedIn":1,"board":{"id":"j39N8YxN","boardName":""},"grade":{"id":"xLuykOqQ","gradeName":""},"assignmentFormatIdToSelect":"42011b54-6f7e-4e4c-b359-ad7f005db0bc"}}}';
        $requestJSON = '{"data":{"id":"33b88170-998c-49e8-823f-ad8d00d766d2","ownerId":"107540876783757283921","formatName":"Test Date","inputTitle":"test","selectBoard":"j39N8YxN","selectSubject":"VOTBhxSi","selectGrade":"xLuykOqQ","selectTopic":"0IVvoKAa,muJaltt4,LhIYwxBw,gLxYFCk1,3zlldJn4,Ot0NkJwg,UAfdxiWI,rTmjIqDb,8H9Kv4iT,92tOXzNw,8mi61iyU,5eeZKnkb,GgNrrVoK,Hj3wTZ6L,09kn2nwP","selectSubTopic":"06CBNF4L,Qfa5NJmc,Iayi7OKZ,cAgb10iS,JBqVjbuW,Lni5YBH3,9nBXdezY,LuqNHA7i,p7ZxR8QP,T8aLX78l,ed38gxph,BYwhtZYb,5i9s3f8D,8NqYit8o,76D8EGQQ,VXK10szs,TPw8Wvk4,5bJIPuXQ,qLnP3Hlf,7NFiYx20,YQelHCLf,ZTDnNngH,Kk3jr6Q2,azMxdM5v,8QkrGr9U,ZSMhSNnh,sftyOOmJ,iqedqjLn,06KT6jVE,UQwtyZbC,gx2Jn74q,O6nOunks,DHCxs73b,a6TkgV97,s9cotAQe,k4j1RRQH,JnLcVrim,hzMY9CaF,Wj8Y6UhF,cGCQOXtV,LbUQ5uGG,NRu5weMC,eDDD77W1,4jcP7kzN,Apeju6dc,DRa2jNh4,BwZX8Ywm,MyXj1pfi,VhyjXZIz,LuJ36LHA,MKszSplv,qEASqiUr,lFlyWjgm,tvVnJ261,XP9iH46d,nYgofgxE,Nrbcr9LC,MpwYygw3,Ng4Visib,orMdR8g8,n1zqk05C,XEHLtPPA,EGpGB9r6,Skb6F3JQ,x5dfTL78,oPyfJ90y,h1qvI8kI,7uravItI,mugy7ScF,LHTkbkhg,YEmz9wfZ,20KggkAw,zvTTU2NB,NBeIv2GV,rkBGw89V,vOcdVuSC,E2dEVy9S,YY25opim,JIKI8wxa,jObt3Jft,l3XB6XEm,g1Z0SfzS,cZ8hvMBs,6jW0935Z,UDIyMQok,y7FmbdPi,tTUJEw3H,ceoOqYhJ,K6p9Jt6C,vv5Fc6Kk,IjLTZ024,tL5DUR04,WgSjgoBm,O75UzSho,rM3hQNRW,Dr6EViDM,wwx1uoVg,RpMhYQIl,QDZKQNgy,6acQhlgi","selectedTemplateId":"33b88170-998c-49e8-823f-ad8d00d766d2","selectedTemplateType":"undefined","difficultyLevel":"3","questionBank":"TutorWand","previousYear":"undefined","isModified":"0","isSkip":"false"},"_token":"WMmRwSxuS3ng1ioSCsERhxYJfZ1q0LiW68o0bIUA","newPaper":"true"}';
        $response = $this->withSession(json_decode($loginJSON, true))
                        ->post('questionreview', json_decode($requestJSON, true));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(['Pts.'], true);
    }

    /**
     * @group ReviewModalReport
     * 
     */
    public function testReviewReportQuestion() {
        $loginJSON = '{"profile":{"userId":"107540876783757283921","firstName":"Teacher1","middleName":"","lastName":"WebCraft IT","emailId":"teacher1@webcraft.co.in","phoneNumber":"","userRoles":[{"roleId":"1","roleName":"TEACHER","description":"Fast track user"}],"profilePicUrl":"https:\/\/lh3.googleusercontent.com\/-XdUIqdMkCWA\/AAAAAAAAAAI\/AAAAAAAAAAA\/4252rscbv5M\/s72-fbw=1\/photo.jpg","settings":{"assignmentFormatIds":["42011b54-6f7e-4e4c-b359-ad7f005db0bc","8b3ce1c3-706d-4332-9664-ad6c005f1c61","dfb5c88d-9512-4eec-8a99-ad83007c0ff1","d57b90ae-f1d7-44a0-9fb0-ad8800c24725","9c8b0a78-5015-4835-9136-ad6d0051c073","eda3b85d-85ff-443d-bc8e-ad83008f3001","bb8d46ea-be2d-4302-a291-ad860060d1a3","551c9b9d-3c80-4f60-939a-ad7f0069b841","715263e2-d6f7-428e-a66a-ad8100a9dd91","11d0524d-5b04-4807-972b-ad7a00971448","a3eca3f1-f9b9-455c-a6ae-ad80005472e1","c840058f-dfe8-4004-b44f-ad7f0083cbf7","137a9180-2ec9-4f88-8fbb-ad7f008b6bd5","f347ed5e-1915-40ca-bfb1-ad8100a97719","6031d7c5-74be-455b-a9f6-ad7a0096e167","3083f8c6-4b2f-4973-be32-ad8100a863db","a7d14d26-0504-468b-91fd-ad8100a7723c","ecbc2028-a9dd-4d45-8882-ad7f008a3c94","4c5fd4a6-633d-4022-90f7-ad7f009117f9","1e0f7bec-d512-4e1f-a25a-ad7f0087920e","4a855753-96ef-4722-85fc-ad7f00831d88","da356b7a-e480-48c1-a9bc-ad7f0069c195","65855f9a-363f-49bf-b17d-ad7d00d35bdf","4ea51dd9-fb4b-4668-bdea-ad6e0073066b","1ccbf1b7-1767-4dde-aeac-ad7b0090f1b4","62a04985-b004-4350-8177-ad7c00738c4a","0f0b8191-2e89-4473-b1cd-ad72008f944b","da040a53-021e-40d2-8c69-ad74006d5b6f","c4563b0c-aaff-481f-a994-ad7900d2b331","89ad7ce0-fc1c-4549-aae1-ad7a00960e83","169f0780-80c6-445a-83b0-ad6f006b53b0","bfb5f4fd-69a0-4796-aa8e-ad7200928e4b","8109867a-1970-4c9b-9e7e-ad7300c229a5","f685d0a3-a2ff-45b9-b109-ad7500ce0347","d8c20469-9e9f-4d23-bec5-ad7500cea617","5243e2e2-aacc-48d6-ba86-ad74006feff9","a3263ccd-1b8e-4753-876b-ad7300c28648","0b821116-c324-4a1a-bc37-ad6c0058c29c","309b26c3-d2c0-4831-9797-ad6f006e68bd","64bc6316-68d8-4704-97b2-ad6f006e5850","cbca2bc7-de1e-4d40-8b47-ad6e007455f6","7e05633b-a9b2-4b01-be17-ad6e0062fd9a","64af505a-a06c-4f77-91ca-ad6e005cfd70","d4d59124-5e9e-4ed2-8ef0-ad6e004a77dd","dd738ac8-f4af-475f-a9d8-ad6d010c319d","0d6581c7-daf9-42d5-b9e1-ad6c00f1527b","5f656898-5352-481f-a16f-ad6d00a244a9","c3c97bc4-9c33-4cf3-af42-ad6d00ab2aeb","e236dcd0-31b5-4a5f-8d94-ad6d009d41f6","e4e02328-7234-4210-b7b3-ad6d009048af","d39fd495-b2b3-4103-b29d-ad6d008e2112","3b52a79d-e6ee-44e9-a70c-ad6c0058c29d","0a33e9c7-64b5-401c-a1e5-ad6c0058c29d"],"isLoggedIn":1,"board":{"id":"j39N8YxN","boardName":""},"grade":{"id":"xLuykOqQ","gradeName":""},"assignmentFormatIdToSelect":"42011b54-6f7e-4e4c-b359-ad7f005db0bc"}}}';
        $requestJSON = '{"id":"2b8b09e0-1551-4bde-b38f-ad5e00a9402b","issueIds":"[\"XcjmE6ah\",\"Uhif5cdC\"]"}';
        $response = $this->withSession(json_decode($loginJSON, true))
                        ->post('get/modal/question/report', json_decode($requestJSON, true));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(["-", "-", "-", "-"], true);
    }
}
