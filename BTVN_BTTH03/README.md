# APP_KEY=base64:WQYxlTrg9eu47q3F+D7Rs+/w3J7wFkaXJ0nW5RQIgsQ=
# Thêm Composer vào PATH tạm thời
$env:Path += ";D:\composer"

# Kiểm tra lại
composer --version
APP_KEY=base64:WQYxlTrg9eu47q3F+D7Rs+/w3J7wFkaXJ0nW5RQIgsQ=
# Thêm PHP từ XAMPP vào PATH
$env:Path += ";D:\xampp82\php"

# Kiểm tra PHP
php --version

# Kiểm tra Composer
composer --version


composer create-project --prefer-dist laravel/laravel ten-du-an

composer global require laravel/installer
laravel new ten-du-an

composer create-project --prefer-dist laravel/laravel test "8.*"

cd test

composer install
php artisan serve


-- file .bat: @"D:\xampp82\php\php.exe" "%~dp0composer.phar" %*

-- .\composer create-project --prefer-dist laravel/laravel cse485_chapter6

-- D:\xampp82\php\php.exe .\composer create-project --prefer-dist laravel/laravel cse485_chapter6
-- D:\xampp82\php\php.exe D:\xampp82\htdocs\cse485\composer.phar create-project --prefer-dist laravel/laravel cse485_chapter6


--BTTH03:

# Kiểm tra biến COMPOSER hiện tại
echo $env:COMPOSER

# Xóa nó
$env:COMPOSER = $null

# Thử lại lệnh composer
composer create-project laravel/laravel task-list-app
Cách 1: Tạo trực tiếp: composer create-project laravel/laravel task-list-app

# 3. Tạo Cơ sở dữ liệu (Tạo các tệp migration)
# Bước 1: Di chuyển vào thư mục dự án
cd task-list-app
# Bước 2: Tạo migration cho bảng tasks
php artisan make:migration create_tasks_table --create=tasks

# Bước 3: Mở file migration vừa tạo trong thư mục database/migrations và thay
# thế nội dung bằng đoạn mã sau:
public function up(): void
 {
 Schema::create('tasks', function (Blueprint $table)
{
 $table->id();
 $table->string('title');
 $table->text('description');
 $table->text('long_description')->nullable();
 $table->boolean('completed')->default(false);
 $table->timestamps();
 });
 } 
# Bước 4: .env: Thay đổi biến môi trường 
# Bước 5: Chạy migration
Chạy lệnh sau để tạo bảng tasks trong cơ sở dữ liệu:
php artisan migrate

# Bước 6: Tạo Model
Tạo model Task bằng lệnh sau:
php artisan make:model Task

# Bước 7: Tạo Factory
# Tạo factory cho model Task để sinh dữ liệu giả:
php artisan make:factory TaskFactory
Mở file factory vừa tạo trong thư mục database/factories và thay thế nội
dung bằng đoạn mã sau:
public function definition(): array
 {
 return [
 'title' => fake()->sentence(),
 'description' => fake()->paragraph(),
 'long_description' => fake()->text(),
 'completed' => fake()->boolean(),
 ];
 }


# Bước 8: Sinh dữ liệu giả
Mở file database/seeders/DatabaseSeeder.php và thêm dòng sau vào
hàm run():
            \App\Models\Task::factory(10)->create();
Chạy lệnh sau để sinh 10 task giả:
            php artisan db:seed

# Bước 9: (Tùy chọn) Tạo Controller và Route
Bạn có thể tạo controller và route để hiển thị danh sách task, tạo task mới, v.v.
Ví dụ:
    php artisan make:controller TaskController –resource
    php artisan make:controller TaskController --resource
Thêm route vào file routes/web.php:
    Route::resource('tasks', TaskController::class);


---- BTVN TH03
php artisan make:migration create_classrooms_table
php artisan make:migration create_schedules_table
php artisan make:seeder ClassroomSeeder

php artisan make:seeder ScheduleSeeder
use Illuminate\Support\Facades\DB;

php artisan migrate:fresh
php artisan db:seed