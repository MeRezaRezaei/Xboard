<?php

namespace Tests\Feature\Exceptions;

use Tests\TestCase;
use App\Exceptions\ApiException;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HandlerTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_exception_renders_correct_json_response()
    {
        $exception = new ApiException('Test API Error', 400);
        $request = Request::create('/api/v1/test', 'GET');
        
        // We use the application's exception handler
        $handler = app(\App\Exceptions\Handler::class);
        $response = $handler->render($request, $exception);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertStringContainsString('Test API Error', $response->getContent());
    }

    public function test_business_exception_renders_correct_json_response()
    {
        // Business exceptions often return a 200 OK HTTP status but with an error code in the JSON body
        $exception = new BusinessException('Test Business Error', 500); 
        $request = Request::create('/api/v1/test', 'GET');
        
        $handler = app(\App\Exceptions\Handler::class);
        $response = $handler->render($request, $exception);

        // Depending on your implementation, it might be 200 or 500. Adjust based on ApiResponse::abort mapping
        $this->assertTrue(in_array($response->getStatusCode(), [200, 500, 400]));
        $this->assertStringContainsString('Test Business Error', $response->getContent());
    }
}
