

# Project Title

To Do List (REST API)

### Prerequisites

* Install Laravel dan Composer
* Mengubah env.txt menjadi .env
* Buat database dengan nama ToDoList
* Import ToDoList_2018-01-29.sql ke database

### Route

| Domain | Method | URI | Name | Action | Middleware |
| --- | --- | --- | --- | --- | --- |
| | POST | api/login | | App\Http\Controllers\UserController@authenticate | api,cors |
| | POST | api/logout | | App\Http\Controllers\UserController@logout | api,cors,jwt.auth |
| | POST | api/register | | App\Http\Controllers\UserController@registerUser | api,cors |
| | GET.HEAD | api/todo | todo.index | App\Http\Controllers\ToDoListController@index | api,cors,jwt.auth |
| | POST | api/todo | todo.store | App\Http\Controllers\ToDoListController@store | api,cors,jwt.auth |
| | GET.HEAD | api/todo/done | | App\Http\Controllers\ToDoListController@showDoneToDoList | api,cors,jwt.auth |
| | GET.HEAD | api/todo/incomplete | | App\Http\Controllers\ToDoListController@inCompleteToDoList | api,cors,jwt.auth |
| | GET.HEAD | api/todo/sorted | | App\Http\Controllers\ToDoListController@getDataSorted | api,cors,jwt.auth |
| | GET.HEAD | api/todo/{todo} | todo.show | App\Http\Controllers\ToDoListController@show | api,cors,jwt.auth |
| | PUT.PATCH | api/todo/{todo} | todo.update | App\Http\Controllers\ToDoListController@update | api,cors,jwt.auth |
| | DELETE | api/todo/{todo} | todo.destroy | App\Http\Controllers\ToDoListController@destroy | api,cors,jwt.auth |
| | GET.HEAD | api/todo/{todo}/edit | todo.edit | App\Http\Controllers\ToDoListController@edit | api,cors,jwt.auth |

### Running the project

Untuk menjalankan aplikasi
```
php artisan serve
```
Kemudian didapatkan laravel development server, seperti
```
http://127.0.0.1:8000
```
Telah tersedia 2 user pada database
* username:adhistria, password:password
* username:miraheka, password:password
Masukan url
```
http://127.0.0.1:8000/api/login
```
Lalu masukan username dan password yang telah ada, bila ingin membuat user baru dapat menggunakan route register
```
http://127.0.0.1:8000/api/register
```
Untuk melihat seluruh todolist pada user dapat menggunakan url
```
http://127.0.0.1:8000/api/todo
```
Dan untuk menambahkan todolist baru pada user juga dapat menggunakan url tersebut. Sedangkan untuk melihat todolist yang terurut secara ascending berdasarkan priority dapat menggunakan url
```
http://127.0.0.1:8000/api/todo/sorted?asc
```
bila ingin terurut secara descending dapat menggunakan url
```
http://127.0.0.1:8000/api/todo/sorted?dsc
```
Dan untuk melihat todolist yang telah dikerjakan dapat menggunakan url
```
http://127.0.0.1:8000/api/todo/done
```
Sedangkan todolist yang belum dikerjakan dapat diakses pada
```
http://127.0.0.1:8000/api/todo/incomplete
```

## Built With
* [Laravel](https://laravel.com/docs/5.5) - The Backend Framework used
* [JWT Auth](https://github.com/tymondesigns/jwt-auth/wiki) - Authentication used

## Authors

* **M.Adhi Satria**
