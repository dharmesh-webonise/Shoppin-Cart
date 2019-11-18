# Shopping Cart API 

User add a prodct to his cart and remove product from cart 

## Installation

Requirements 
 
```bash
PHP 
Apache2
mysql-server
```

```
steps for installation
 - add folder to html directory
 - import database.sql file
 - use below routes.

use Basic auth for authrization 
username  - test-webonise
password  - Test1234
```

## Routes

```
http://localhost/api/

http://localhost/api/product
http://localhost/api/product/add
http://localhost/api/product/$id/edit
http://localhost/api/product/$id (Method GET- "Read one product") (Method Delete- "Delete prodcut from Database") 

http://localhost/api/category
http://localhost/api/category/add
http://localhost/api/category/$id/edit
http://localhost/api/category/$id (Method GET- "Read one product") (Method Delete- "Delete prodcut from Database") 

http://localhost/api/cart
http://localhost/api/cart/add
http://localhost/api/cart/$id (Method Delete- "Delete cart prodcut from cart")

```

