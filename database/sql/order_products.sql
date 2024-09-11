CREATE TABLE order_products
(
    id         INT           NOT NULL AUTO_INCREMENT,
    order_id   INT,
    product_id INT           NOT NULL,

    quantity   INT           NOT NULL,
    price      DECIMAL(8, 2) NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE SET NULL,
    FOREIGN KEY (product_id) REFERENCES products (id)
)