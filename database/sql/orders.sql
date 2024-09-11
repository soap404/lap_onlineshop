CREATE TABLE orders
(
    id                 INT       NOT NULL AUTO_INCREMENT,
    status_id          INT       NOT NULL,
    invoice_address_id INT       NOT NULL,
    address_id         INT,
    user_id            INT,

    order_date         TIMESTAMP NOT NULL,
    invoice_pdf        VARCHAR(500),

    PRIMARY KEY (id),
    FOREIGN KEY (status_id) REFERENCES status (id),
    FOREIGN KEY (invoice_address_id) REFERENCES invoice_addresses (id),
    FOREIGN KEY (address_id) REFERENCES addresses (id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL
)