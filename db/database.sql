CREATE DATABASE "HOTLIBRARY";

CREATE TABLE "Level" (
  "id"        SERIAL        NOT NULL,
  "type"      VARCHAR(100)  NOT NULL UNIQUE,
  PRIMARY KEY ("id")
);

INSERT INTO "Level" ("type") VALUES ('admin'),('library');

CREATE TABLE "User"(
  "id"        SERIAL        NOT NULL,
  "name"      VARCHAR(100)  NOT NULL,
  "email"     VARCHAR(100)  NOT NULL  UNIQUE,
  "password"  VARCHAR(128)  NOT NULL,
  "level"     INTEGER       NOT NULL,
  "isActive"  BOOLEAN       NOT NULL  DEFAULT TRUE,
  PRIMARY KEY ("id"),
  CONSTRAINT fk_user_level
    FOREIGN KEY ("level") REFERENCES "Level" ("id") ON DELETE RESTRICT ON UPDATE CASCADE
);
-- Usuário admin senha 'teste123'
INSERT INTO "User" ("name","email","password","level") VALUES('admin','admin@hotlibrary.com','535f56e6447ea0fcf3ef1bf5397066d037e9ebb7fd141068e8de9a23ece8eb6e7acf46d0e6bbf17edf2ebe6c80405991be53366138e835c3153019f164340619',1);
