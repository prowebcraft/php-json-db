# php-json-db
Simple And Flexible database in JSON file

#Installation
```bash
composer require prowebcraft/php-json-db
```

#Usage
Create JsonDb instance
```php
$db = new JsonDb([
  'name' => 'users.json',
  'dir' => getcwd()
]);
```

Add some data
```php 
$db->set('user', [
    'firstname' => 'John',
    'lastname' => 'Doe'
]);
```

Add more data to existing array
```php
$db->set('user.age', 18);
```

Save data to storage
```php
$db->save();
```

You will get file in current working directory named *users.json* with sample data:
```json
{
    "user": {
        "firstname": "John",
        "lastname": "Doe",
        "age": 18
    }
}
```

Get items
```php
$db->get('user.age');
```