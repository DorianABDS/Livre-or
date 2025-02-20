-- Supprime la table si elle existe déjà
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS comment;



-- Création de la table user
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Création de la table comment avec une clé étrangère vers user
CREATE TABLE comment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comment TEXT NOT NULL,
    id_user INT NOT NULL,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_comment_user FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB;
