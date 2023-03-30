<?php

use App\Http\Controllers\AbstractCrudController;
use Illuminate\Http\Request;
use Tests\TestCase;

class AbstractCrudControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        App\Models\Employee::factory()->create();
        App\Models\Client::factory()->create();
        App\Models\Order::factory()->create();
        App\Models\Car::factory()->create();
    }

    public function testCreate()
    {
        foreach(["Car", "Client", "Order", "Employee"] as $modelName) {
            $name = 'Test';
            $response = $this->post("/api/create/$modelName/", ['name' => $name]);
            $model = $response->original;
            $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $model);
            $this->assertEquals($name, $model->name);
        }
    }

    public function testRead()
    {
        foreach(["Car", "Client", "Order", "Employee"] as $modelName) {
            $controller = $this->getMockForAbstractClass(AbstractCrudController::class, [new Request()]);
            $response = $this->get("/api/read/$modelName/");
            $response = $response->original;
            if (is_array($response)) {
                $this->assertIsArray($response);
            } else if ($response !== null) {
                $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $response);
            } else {
                $this->assertNull($response);
            }
        }

    }

    public function testUpdate()
    {
        foreach(["Car", "Client", "Order", "Employee"] as $modelName) {
            $controller = $this->getMockForAbstractClass(AbstractCrudController::class, [new Request()]);
            $response = $this->put("/api/update/$modelName/test",["name"=>"Test"]);
            $response = $response->original;
            $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $response);

        }
    }

    public function testDelete()
    {

        foreach(["Car", "Client", "Order", "Employee"] as $modelName) {
            $controller = $this->getMockForAbstractClass(AbstractCrudController::class, [new Request()]);
            $response = $this->delete("/api/delete/$modelName/1",["name"=>"Test"]);
            $response = $response->original;
            $this->assertIsBool($response);
        }
    }
}
