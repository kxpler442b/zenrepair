CREATE TABLE zenrepair.users (
	id varchar(13) NOT NULL,
	email_address varchar(100) NOT NULL,
	mobile_number varchar(100) NULL,
	first_name varchar(100) NULL,
	last_name varchar(100) NULL,
	oauth_token varchar(100) NULL,
	is_admin BOOL NULL,
	created DATE NULL,
	updated DATETIME NULL,
	CONSTRAINT users_PK PRIMARY KEY (id),
	CONSTRAINT users_UN UNIQUE KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE zenrepair.customers (
	id varchar(13) NOT NULL,
	email_address varchar(100) NOT NULL,
	mobile_number varchar(100) NULL,
	first_name varchar(100) NULL,
	last_name varchar(100) NULL,
	access_code varchar(100) NULL,
	created DATE NULL,
	updated DATETIME NULL,
	CONSTRAINT customers_PK PRIMARY KEY (id),
	CONSTRAINT customers_UN UNIQUE KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE zenrepair.devices (
	id varchar(13) NOT NULL,
	serial_number varchar(100) NOT NULL,
	imei SMALLINT(15) NULL,
	model varchar(100) NULL,
	manufacturer varchar(100) NULL,
	location varchar(64) NULL,
	assoc_customer varchar(13) NOT NULL,
	created DATE NULL,
	updated DATETIME NULL,
	CONSTRAINT devices_PK PRIMARY KEY (id),
	CONSTRAINT devices_UN UNIQUE KEY (id),
	CONSTRAINT devices_FK FOREIGN KEY (assoc_customer) REFERENCES zenrepair.customers(id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE zenrepair.tickets (
	id varchar(13) NOT NULL,
	subject varchar(100) NULL,
	status SMALLINT NULL,
	notes json NULL,
	assoc_user VARCHAR(13) NOT NULL,
	assoc_customer varchar(13) NOT NULL,
	assoc_device varchar(13) NOT NULL,
	created DATE NULL,
	updated DATETIME NULL,
	CONSTRAINT tickets_PK PRIMARY KEY (id),
	CONSTRAINT tickets_UN UNIQUE KEY (id),
	CONSTRAINT tickets_FK FOREIGN KEY (assoc_user) REFERENCES zenrepair.users(id),
	CONSTRAINT tickets_FK_1 FOREIGN KEY (assoc_customer) REFERENCES zenrepair.customers(id),
	CONSTRAINT tickets_FK_2 FOREIGN KEY (assoc_device) REFERENCES zenrepair.devices(id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;