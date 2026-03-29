CREATE TABLE IF NOT EXISTS clients (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT,
    company_name VARCHAR(255),
    website VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(255),
    client_access_code VARCHAR(255) NOT NULL,
    url VARCHAR(255),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY clients_client_access_code_unique (client_access_code)
);
