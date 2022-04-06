# Endpoints

## Base:

```
/wp-json/dp-api/v1/
{
    method:GET
}
```

### Get All Products

```
/wp-json/dp-api/v1/products
{
    method:GET
}
```

### Get Single Product

```
/wp-json/dp-api/v1/product/<id>
{
    method:GET
}
```

### Get All Categories

```
/wp-json/dp-api/v1/products/categories
{
    method:GET
}
```

### Get Single category

```
/wp-json/dp-api/v1/products/category/<id>
{
    method:GET
}
```

### Get user Info

```
/wp-json/dp-api/v1/userinfo/<id>
{
    method:GET
}
```

### Update User Password

```
{
    method:POST,
    params:{
        user_id:integer,
        old_password:string(base64),
        new_password:string(base64)
    }
}
```

### Get Single order by id

```
/wp-json/dp-api/v1/single_order
{
    method:GET,
    params:
    {
    order_id:integer
    }
}
```

### Get cart

```
/wp-json/dp-api/v1/cart
{
    method:GET
}
```

### Add to cart

```
/wp-json/dp-api/v1/add_to_cart
{
    method:POST
    params:
    {
        product_id: integer,
        quantity: integer,
    }
}
```

### Remove from cart

```
/wp-json/dp-api/v1/remove_from_cart
{
    method:POST
    params:
    {
        cart_item_key: string,
    }
}
```
