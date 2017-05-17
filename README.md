# Plane2Ninja
Small utility to export data from Invoice Plane to Invoice Ninja.


## Intro
This is a small Laravel based application that connects directly to a Invoice Plane database. The data is then transformed into a JSON file which is compatible for importing directly into Invoice Ninja

## Limitations
There are some limitations for transferring data out of Invoice Plane and into Invoice Ninja. Invoice Plane has the ability to apply discounts to line items Invoice Ninja does not, there is no way to work around this yet, so if you use extensive line item discounts, this solution may not work for you.

## Setup
1. Download / Clone repo
2. Composer install
3. Configure .env file with your Invoice Plane database credentials
4. Configure Virtual Host
5. Navigate to Web URL
6. Click Download Data!
7. Import into Invoice Ninja
