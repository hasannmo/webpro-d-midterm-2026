<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->product = Product::create([
            'name' => 'Classic Trench Coat',
            'slug' => 'classic-trench-coat',
            'price' => 250000,
            'description' => 'A timeless wardrobe essential.',
            'image' => 'https://example.com/test.jpg',
        ]);
    }

    public function test_guest_is_redirected_to_login_when_accessing_cart(): void
    {
        $response = $this->get(route('cart.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_cart(): void
    {
        $response = $this->actingAs($this->user)->get(route('cart.index'));
        $response->assertStatus(200);
        $response->assertSee('Shopping Cart');
        $response->assertSee('Your cart is empty');
    }

    public function test_user_can_add_product_to_cart(): void
    {
        $response = $this->actingAs($this->user)->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);
    }

    public function test_adding_existing_product_increments_quantity(): void
    {
        CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->user)->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 3,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 5,
        ]);
    }

    public function test_ajax_add_to_cart_returns_json_with_cart_count(): void
    {
        $response = $this->actingAs($this->user)->postJson(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'cart_count' => 2,
        ]);
    }

    public function test_user_can_update_cart_item_quantity(): void
    {
        $cartItem = CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)->patch(route('cart.update', $cartItem->id), [
            'quantity' => 4,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 4,
        ]);
    }

    public function test_user_can_remove_item_from_cart(): void
    {
        $cartItem = CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)->delete(route('cart.remove', $cartItem->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id,
        ]);
    }

    public function test_user_can_checkout_cart_and_create_orders(): void
    {
        $secondProduct = Product::create([
            'name' => 'Wool Knit Sweater',
            'slug' => 'wool-knit-sweater',
            'price' => 120000,
            'description' => 'Cozy knitwear.',
            'image' => 'https://example.com/knit.jpg',
        ]);

        CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $secondProduct->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)->post(route('cart.checkout'));

        $response->assertRedirect(route('myorder'));
        $this->assertDatabaseEmpty('cart_items');

        // Verify orders created for the user (2 of product, 1 of secondProduct = 3 items total)
        $this->assertEquals(3, Order::where('user_id', $this->user->id)->count());

        $firstOrder = Order::where('user_id', $this->user->id)->where('product_id', $this->product->id)->first();
        $this->assertNotNull($firstOrder);
        $this->assertEquals(250000, $firstOrder->price);
        $this->assertEquals('completed', $firstOrder->status);
    }

    public function test_admin_user_sees_only_own_orders_in_myorder(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'email' => 'admin@example.com']);
        $buyer = User::factory()->create(['role' => 'buyer', 'email' => 'buyer@example.com']);

        // Order placed by buyer
        Order::create([
            'order_number' => 'ORD-BUYER-001',
            'user_id' => $buyer->id,
            'product_id' => $this->product->id,
            'product_name' => 'Buyer Item',
            'price' => 100000,
            'customer_email' => $buyer->email,
            'status' => 'completed',
        ]);

        // Order placed by admin
        Order::create([
            'order_number' => 'ORD-ADMIN-001',
            'user_id' => $admin->id,
            'product_id' => $this->product->id,
            'product_name' => 'Admin Item',
            'price' => 200000,
            'customer_email' => $admin->email,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($admin)->get(route('myorder'));
        $response->assertStatus(200);
        $response->assertSee('ORD-ADMIN-001');
        $response->assertDontSee('ORD-BUYER-001');
    }
}
