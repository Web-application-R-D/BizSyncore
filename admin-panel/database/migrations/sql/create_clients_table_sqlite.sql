CREATE TABLE IF NOT EXISTS clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    address TEXT,
    company_name VARCHAR(255),
    website VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(255),
    client_access_code VARCHAR(255) NOT NULL UNIQUE,
    url VARCHAR(255),
    created_at DATETIME,
    updated_at DATETIME
);
