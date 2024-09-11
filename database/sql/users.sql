CREATE TABLE users
(
    id        INT          NOT NULL AUTO_INCREMENT,
    fname     VARCHAR(255) NOT NULL,
    lname     VARCHAR(255) NOT NULL,
    email     VARCHAR(255) NOT NULL UNIQUE,
    password  VARCHAR(500) NOT NULL,
    is_admin  TINYINT      NOT NULL,
    is_active TINYINT      NOT NULL,

    PRIMARY KEY (id)
)