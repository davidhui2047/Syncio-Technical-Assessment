<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PayloadComparisonTest extends TestCase
{
    
    /**
     * Test if the endpoint can return the correct difference between two payloads
     */
    public function testPayloadComparisonWithDifference()
    {
        $payload1 = [
            "id" => 432232523, 
            "title" => "Syncio T-Shirt"
         ];
        $payload2 = [
            "id" => 432232523, 
            "title" => "Syncio T-Shirt2"
         ]; 

        $this->post('/api/compare-payloads', $payload1);

        $response = $this->post('/api/compare-payloads', $payload2);

        $response->assertStatus(200)
            ->assertJson([
                "differences from old record" => [
                        "title" => "Syncio T-Shirt"
                    ]
            ]);
    }
    
    /**
     * Test if the endpoint can return the correct message when two payloads have no difference
     */
    public function testPayloadComparisonWithNoDifference()
    {
        $payload1 = '{ "id":432232523, "title":"Syncio T-Shirt", "description":"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p><p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus,</p>", "images":[ { "id":26372, "position":1, "url":"https://cu.syncio.co/images/random_image_1.png" }, { "id":23445, "position":2, "url":"https://cu.syncio.co/images/random_image_2.png" }, { "id":34566, "position":3, "url":"https://cu.syncio.co/images/random_image_3.png" }, { "id":33253, "position":4, "url":"https://cu.syncio.co/images/random_image_4.png" }, { "id":56353, "position":5, "url":"https://cu.syncio.co/images/random_image_5.png" } ], "variants":[ { "id":433232, "sku":"SKU-II-10", "barcode":"BAR_CODE_230", "image_id":26372, "inventory_quantity":12 }, { "id":231544, "sku":"SKU-II-20", "barcode":"B231342313", "image_id":23445, "inventory_quantity":2 }, { "id":323245, "sku":"SKU-II-1O", "barcode":"BACDSDE_0", "image_id":34566, "inventory_quantity":8 }, { "id":323445, "sku":"SKU-II-1o", "barcode":"AR_CO23DE_23", "image_id":33253, "inventory_quantity":0 } ] }';
        $payload2 = '{ "id":432232523, "title":"Syncio T-Shirt", "description":"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p><p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus,</p>", "images":[ { "id":26372, "position":1, "url":"https://cu.syncio.co/images/random_image_1.png" }, { "id":23445, "position":2, "url":"https://cu.syncio.co/images/random_image_2.png" }, { "id":34566, "position":3, "url":"https://cu.syncio.co/images/random_image_3.png" }, { "id":33253, "position":4, "url":"https://cu.syncio.co/images/random_image_4.png" }, { "id":56353, "position":5, "url":"https://cu.syncio.co/images/random_image_5.png" } ], "variants":[ { "id":433232, "sku":"SKU-II-10", "barcode":"BAR_CODE_230", "image_id":26372, "inventory_quantity":12 }, { "id":231544, "sku":"SKU-II-20", "barcode":"B231342313", "image_id":23445, "inventory_quantity":2 }, { "id":323245, "sku":"SKU-II-1O", "barcode":"BACDSDE_0", "image_id":34566, "inventory_quantity":8 }, { "id":323445, "sku":"SKU-II-1o", "barcode":"AR_CO23DE_23", "image_id":33253, "inventory_quantity":0 } ] }';


        $this->post('/api/compare-payloads', [
            'payload' => $payload1,
        ]);

        $response = $this->post('/api/compare-payloads', [
            'payload' => $payload2,
        ]);

        $response->assertStatus(200)
                ->assertSee(
                    'There is no difference'
                );
            
    }
    
    /**
     * Test if the endpoint can return the correct message when only one payload get sent
     */
    public function testPayloadComparisonOnePayloadOnly()
    {
        $payload = '{ "id":432232523, "title":"Syncio T-Shirt", "description":"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p><p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus,</p>", "images":[ { "id":26372, "position":1, "url":"https://cu.syncio.co/images/random_image_1.png" }, { "id":23445, "position":2, "url":"https://cu.syncio.co/images/random_image_2.png" }, { "id":34566, "position":3, "url":"https://cu.syncio.co/images/random_image_3.png" }, { "id":33253, "position":4, "url":"https://cu.syncio.co/images/random_image_4.png" }, { "id":56353, "position":5, "url":"https://cu.syncio.co/images/random_image_5.png" } ], "variants":[ { "id":433232, "sku":"SKU-II-10", "barcode":"BAR_CODE_230", "image_id":26372, "inventory_quantity":12 }, { "id":231544, "sku":"SKU-II-20", "barcode":"B231342313", "image_id":23445, "inventory_quantity":2 }, { "id":323245, "sku":"SKU-II-1O", "barcode":"BACDSDE_0", "image_id":34566, "inventory_quantity":8 }, { "id":323445, "sku":"SKU-II-1o", "barcode":"AR_CO23DE_23", "image_id":33253, "inventory_quantity":0 } ] }';

        $response = $this->post('/api/compare-payloads', [
            'payload' => $payload,
        ]);

        $expectedMessage = 'Please send the second payload for checking difference';

        $response->assertStatus(200)
                ->assertSee($expectedMessage);
            
    }


}
