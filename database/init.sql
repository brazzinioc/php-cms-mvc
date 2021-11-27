CREATE DATABASE cms;

-- ROLES.
CREATE TABLE roles(
    id SERIAL,
    role VARCHAR(50),
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT pk_roles PRIMARY KEY (id)
);

INSERT INTO roles(role) VALUES  ('Admin'), ('Writter'), ('Reader');


CREATE TABLE users(
    id SERIAL,
    name VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255), 
    biography TEXT,
    id_role INTEGER NOT NULL DEFAULT 1,
    active BOOLEAN NOT NULL,
    avatar VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT pk_users PRIMARY KEY (id),
    CONSTRAINT un_users UNIQUE(email),
    CONSTRAINT fk_users_roles FOREIGN KEY (id_role) REFERENCES roles(id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

--Default User with Admin role: jhon.doe@cms.com | 12345678
INSERT INTO users(name, lastname, email, password, biography, active, id_role, avatar)
VALUES ('Jhon', 'Doe Does', 'jhon.doe@cms.com', '$2y$12$jhG/S0S1/4x/JUX/iFssuOY7xfNiSZ02COgRUQ0.aTbmZ3OPI8SuS', 'I am super super user :)', TRUE, 1, 'default.png');


CREATE TABLE categories
(
    id SERIAL,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_at TIMESTAMP NOT NULL,
    CONSTRAINT pk_categories PRIMARY KEY(id),
    CONSTRAINT un_categories UNIQUE(name)
);

INSERT INTO categories (name, created_at, updated_at)
VALUES 
('Frontend', NOW(), NOW()),
('Backend', NOW(), NOW()),
('Devops', NOW(), NOW()),
('Database', NOW(), NOW()),
('Networking', NOW(), NOW()),
('Hacking', NOW(), NOW()),
('Cloud', NOW(), NOW());


--Posts
CREATE TABLE posts
(
    id SERIAL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    img_cover VARCHAR(255),
    id_user INTEGER NOT NULL,
    id_category INTEGER NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_at TIMESTAMP NOT NULL,
    CONSTRAINT pk_posts PRIMARY KEY(id),
    CONSTRAINT fk_posts_users FOREIGN KEY(id_user) REFERENCES users(id) ON UPDATE RESTRICT ON DELETE CASCADE,
    CONSTRAINT fk_posts_categories FOREIGN KEY(id_category) REFERENCES categories(id) ON UPDATE RESTRICT ON DELETE CASCADE
);


CREATE TABLE comments
(
    id SERIAL, 
    comment TEXT NOT NULL,
    id_post INTEGER NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_at TIMESTAMP NOT NULL,
    CONSTRAINT pk_comments PRIMARY KEY(id),
    CONSTRAINT fk_comments_authors FOREIGN KEY(id_post) REFERENCES posts(id) ON UPDATE RESTRICT ON DELETE CASCADE 
);