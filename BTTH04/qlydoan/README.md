<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).0
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://larave00o check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

--------------------
# cd qlyduan    
# php artisan migrate:fresh --seed
# php artisan make:migration create_computers_table
  Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->string('computers_name', 50);
            $table->string('model', 100);
            $table->string("operating_system", 50);
            $table->string("processor", 50);
            $table->integer('memory');
            $table->boolean('available');
            $table->timestamps();
        });

 Schema::create('issues', function (Blueprint $table) {
            $table->id();
            # để lấy khóa ngoại dùng foreignID -> constrained 
            $table->foreignId('computer_id')->constrained("computers");
            $table->string('reported_by', 50);
            $table->date('reported_date', );
            $table->text('description');
            $table->enum('urgency', ['Low', 'Medium', 'High']);
            $table->enum('status', ['Open', 'In Progress', 'Resolved']);
            $table->timestamps();
        });

# php artisan make:seeder ComputersTableSeeder
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class ComputersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('computers')->insert([
                'computer_name' => $faker->word . ' PC',
                'model' => $faker->word . ' Model',
                'operating_system' => $faker->randomElement(['Windows 10 Pro', 'Windows 11 Home', 'Ubuntu 22.04']), // [cite: 5]
                'last_name' => $faker->lastName,
                'processor' => $faker->randomElement(['Intel Core i5-11400', 'Intel Core i7-12700']), // [cite: 6]
                'memory' => $faker->randomElement([10, 20, 10]),
                'available' => $faker->boolean(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

# php artisan make:seeder IssuesTableSeeder

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class IssuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        $computerIds = DB::table('computers')->pluck('id')->toArray();
        foreach (range(1, 50) as $index) { // Đảm bảo tối thiểu 50 bản ghi 
            DB::table('issues')->insert([
                'computer_id' => $faker->randomElement($computerIds), // Khóa ngoại 
                'reported_by' => $faker->name, // Người báo cáo [cite: 11]
                'reported_date' => $faker->dateTimeThisYear(), // Thời gian báo cáo [cite: 12]
                'description' => $faker->paragraph, // Mô tả chi tiết [cite: 13]
                'urgency' => $faker->randomElement(['Low', 'Medium', 'High']), // Mức độ [cite: 14]
                'status' => $faker->randomElement(['Open', 'In Progress', 'Resolved']), // Trạng thái [cite: 15]
                'created_at' => now(),
                'updated_at' => now(),
            ]);



        }
    }
}

# php artisan migrate

# php artisan migrate:fresh --seed

# php artisan make:controller IssueController

# php artisan make:model Computers