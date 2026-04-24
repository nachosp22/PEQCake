<?php

namespace Tests\Feature;

use App\Exports\MonthlyOrdersExport;
use App\Models\Cake;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class AdminReportsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_reports_section(): void
    {
        $adminLoginPath = '/'.trim((string) config('peq.admin_path'), '/').'/login';

        $this->get(route('admin.reports.index'))->assertRedirect($adminLoginPath);
    }

    public function test_authenticated_admin_can_access_reports_section(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.reports.index'));

        $response->assertOk();
        $response->assertSee('Informes de Pedidos');
        $response->assertSee('name="from"', false);
        $response->assertSee('name="to"', false);
        $response->assertSee(route('admin.reports.export-orders'), false);
    }

    public function test_reports_index_uses_month_range_defaults_when_query_is_invalid(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.reports.index', [
            'from' => 'not-a-date',
            'to' => 'bad-value',
        ]));

        $response->assertOk();
        $response->assertViewHas('from', now()->startOfMonth()->format('Y-m-d'));
        $response->assertViewHas('to', now()->endOfMonth()->format('Y-m-d'));
    }

    public function test_admin_can_download_orders_excel_for_selected_date_range(): void
    {
        Excel::fake();

        $admin = User::factory()->create();
        $cake = Cake::create([
            'name' => 'Report Cake',
            'description' => 'Monthly report',
            'price' => 30,
            'is_available' => true,
        ]);

        $includedOrder = Order::create([
            'cake_id' => $cake->id,
            'items' => [[
                'cake_id' => $cake->id,
                'cake_name' => $cake->name,
                'size' => 'BITE',
                'quantity' => 1,
                'unit_price' => 30,
                'line_total' => 30,
            ]],
            'customer_name' => 'Cliente Dentro de Rango',
            'customer_email' => 'marzo@example.com',
            'customer_phone' => '611111113',
            'pickup_date' => '2026-03-10',
            'total' => 30,
            'status' => 'paid',
        ]);

        Order::create([
            'cake_id' => $cake->id,
            'items' => [[
                'cake_id' => $cake->id,
                'cake_name' => $cake->name,
                'size' => 'BITE',
                'quantity' => 1,
                'unit_price' => 30,
                'line_total' => 30,
            ]],
            'customer_name' => 'Cliente Fuera de Rango',
            'customer_email' => 'abril@example.com',
            'customer_phone' => '611111114',
            'pickup_date' => '2026-04-04',
            'total' => 30,
            'status' => 'paid',
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.reports.export-orders'), [
                'from' => '2026-03-01',
                'to' => '2026-03-31',
            ]);

        $response->assertStatus(200);

        Excel::assertDownloaded('informe_PEQ_desde_2026-03-01_hasta_2026-03-31.xlsx', function (MonthlyOrdersExport $export) use ($includedOrder): bool {
            $ids = $export->collection()->pluck('id')->all();

            return $ids === [$includedOrder->id];
        });
    }

    public function test_admin_can_download_orders_excel_when_range_has_no_orders(): void
    {
        Excel::fake();

        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->post(route('admin.reports.export-orders'), [
                'from' => '2026-07-01',
                'to' => '2026-07-31',
            ]);

        $response->assertStatus(200);

        Excel::assertDownloaded('informe_PEQ_desde_2026-07-01_hasta_2026-07-31.xlsx', function (MonthlyOrdersExport $export): bool {
            return $export->collection()->isEmpty() && count($export->headings()) > 0;
        });
    }

    public function test_export_orders_requires_date_fields_and_does_not_download_file_on_validation_error(): void
    {
        Excel::fake();

        $admin = User::factory()->create();

        $response = $this->from(route('admin.reports.index'))
            ->actingAs($admin)
            ->post(route('admin.reports.export-orders'), []);

        $response->assertRedirect(route('admin.reports.index'));
        $response->assertSessionHasErrors(['from', 'to']);
    }

    public function test_export_orders_validates_to_date_is_not_before_from_date(): void
    {
        Excel::fake();

        $admin = User::factory()->create();

        $response = $this->from(route('admin.reports.index'))
            ->actingAs($admin)
            ->post(route('admin.reports.export-orders'), [
                'from' => '2026-04-10',
                'to' => '2026-04-09',
            ]);

        $response->assertRedirect(route('admin.reports.index'));
        $response->assertSessionHasErrors(['to']);
    }
}
