# 🐳 Flora PHP + Symfony Challenge

## Description

### Exercise 1

- _Example 1_ (Product A added + Product C added + Voucher S added + Product A added + Voucher V added + Product B added):

  - at `./docker` folder:
    `$ docker-compose run php bin/console flora:calculate:cart --example=1`

- _Example 2_ (Product A added + Voucher S added + Product A added + Voucher V added + Product B added + Voucher R added + Product C added + Product C added + Product C added):

  - at `./docker` folder:
    `$ docker-compose run php bin/console flora:calculate:cart --example=2`

- Tests:

  `$ docker-compose run php vendor/phpunit/phpunit/phpunit --testdox src/AddToCartCommandTest.php`

#### Expected result

    ========================Flora Challenge Begin======================

    +-------------------- Cart ------------+---------+
    | id                                   | price   |
    +--------------------------------------+---------+
    | A                                    | order 1 |
    | B                                    | order 2 |
    +----------------- total cart: 2€ -----+---------+

    ========================Flora Challenge End========================

### Exercise 2

1.  ```
    SELECT
        YEAR(order_date) AS year,
        MONTH(order_date) AS month,
        SUM(total_amount) AS revenue
    FROM
        Orders
    WHERE
        YEAR(order_date) = 2022
    GROUP BY
        YEAR(order_date),
        MONTH(order_date);
    ```

2.  ```
    SELECT
        Products.name,
        SUM(Order_Items.quantity * Order_Items.unit_price) AS revenue
    FROM
        Products
    INNER JOIN
        Order_Items
    ON
        Products.id = Order_Items.product_id
    INNER JOIN
        Orders
    ON
        Order_Items.order_id = Orders.id
    WHERE
        YEAR(Orders.order_date) = 2021
    GROUP BY
        Products.id
    ORDER BY
        revenue DESC
    LIMIT
        5;
    ```

3.  ```
    SELECT
        Customers.name,
        SUM(Orders.total_amount) AS total_spent
    FROM
        Customers
    INNER JOIN
        Orders
    ON
        Customers.id = Orders.customer_id
    WHERE
        YEAR(Orders.order_date) = 2020
    GROUP BY
        Customers.id
    ORDER BY
        total_spent DESC
    LIMIT
        10;
    ```

4.  ```
    SELECT
        Customers.name,
        AVG(Orders.total_amount) AS avg_order_value
    FROM
        Customers
    INNER JOIN
        Orders
    ON
        Customers.id = Orders.customer_id
    WHERE
        YEAR(Orders.order_date) = 2021
    GROUP BY
        Customers.id;
    ```

5.  ```
    SELECT
        SUM(total_amount) AS revenue
    FROM
        Orders
    INNER JOIN
        Order_Items
    ON
        Orders.id = Order_Items.order_id
    INNER JOIN
        Products
    ON
        Order_Items.product_id = Products.id
    WHERE
        Products.name LIKE '%blue%';
    ```
