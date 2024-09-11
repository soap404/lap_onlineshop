CREATE TABLE products
(
    id          INT           NOT NULL AUTO_INCREMENT,
    name        VARCHAR(255)  NOT NULL,
    description LONGTEXT,
    price       DECIMAL(8, 2) NOT NULL,
    stock       INT           NOT NULL,
    img         VARCHAR(255),
    is_active   TINYINT       NOT NULL,

    PRIMARY KEY (id)
)