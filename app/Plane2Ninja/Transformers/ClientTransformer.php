<?php
namespace App\Plane2Ninja\Transformers;
use App\Models\Client;
use App\Plane2Ninja\Ninja\NinjaFactory;
class ClientTransformer extends BaseTransformer
{
    public function transform(Client $client)
    {
        $ninjaFactory = new NinjaFactory(new ClientTransformer(), new InvoiceTransformer(), new PaymentTransformer(), new InvoiceItemTransformer(), new ProductTransformer(), new QuoteTransformer(), new QuoteItemTransformer());
        return [
            'id' => $client->client_id,
            'name' => $client->client_ame,
            'balance' => 0,
            'paid_to_date' => 0,
            'address1' => $client->client_address_1,
            'address2' => $client->client_address_2,
            'city' => $client->client_city,
            'state' => $client->client_state,
            'postal_code' => $client->client_zip,
            'country_id' => '',
            'work_phone' => $this->getString($client->client_phone),
            'private_notes' => $this->formatNotes($client->notes()),
            'last_login' => '',
            'website' => $this->getString($client->client_web),
            'industry_id' => 0,
            'size_id' => 0,
            'is_deleted' => 0,
            'payment_terms' => 0,
            'vat_number' => $this->getString($client->client_vat_id),
            'id_number' => '',
            'language_id' => 0,
            'currency_id' => 0,
            'custom_value1' => '',
            'custom_value2' => '',
            'invoice_number_counter' => 1,
            'quote_number_counter' => 1,
            'contacts' => [
                [
                    'first_name' => $client->client_name,
                    'last_name' => $this->getString($client->client_surname),
                    'email' => $client->client_email ? $client->client_email : 'no_email_set@some_email.com',
                    'phone' => $this->getContactPhone($client),
                ],
            ],
            'invoices' => array_merge($ninjaFactory->buildInvoices($client->invoices()->get()), $ninjaFactory->buildQuotes($client->quotes()->get()))
        ];
    }
}