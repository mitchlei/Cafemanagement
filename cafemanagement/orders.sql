
CREATE TABLE order_tables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total_amount DECIMAL(10,2),
    payment_method VARCHAR(20),
    order_date DATETIME 
);


CREATE TABLE order_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

