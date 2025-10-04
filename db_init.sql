CREATE TABLE IF NOT EXISTS personas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  edad INT
);

INSERT INTO personas (nombre, edad) VALUES
('Sofía', 30),
('Cristian', 27),
('Juan', 35);
