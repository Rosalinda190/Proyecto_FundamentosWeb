<?php   //uso de la base de datos

    require_once 'conexion.php';

    class CAD {
        private $conexion;

        public function __construct() {
            $this->conexion = new Conexion();
        }

        public function registerUser($username, $password, $email) {
            try {
                $query = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, 'user')";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->bindParam(':username', $username);
                $resultado->bindParam(':password', $password);
                $resultado->bindParam(':email', $email);
                $resultado->execute();

                return $resultado->rowCount() > 0; 

            } catch (PDOException $e) {
                return false;
            }
        }    

        public function loginUser($email, $password) {
            $query = "SELECT * FROM users WHERE email = :email";
            $resultado = $this->conexion->conectar()->prepare($query);
            $resultado->bindParam(':email', $email);
            $resultado->execute();
            $user = $resultado->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    return $user; 
                } else {
                    echo "Contraseña incorrecta.";
                }
            } else {
                echo "Usuario no encontrado.";
            }

            return false; 
        }


        public function createRecipe($title, $category, $difficulty, $ingredients, $instructions, $image, $user_id) {
            try {
                $query = "INSERT INTO recipes (title, category, difficulty, ingredients, instructions, image, user_id, created_at) 
                          VALUES (:title, :category, :difficulty, :ingredients, :instructions, :image, :user_id, NOW())";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->bindParam(':title', $title);
                $resultado->bindParam(':category', $category);
                $resultado->bindParam(':difficulty', $difficulty);
                $resultado->bindParam(':ingredients', $ingredients);
                $resultado->bindParam(':instructions', $instructions);
                $resultado->bindParam(':image', $image, PDO::PARAM_LOB);
                $resultado->bindParam(':user_id', $user_id);
        
                return $resultado->execute();
            } catch (PDOException $e) {
                error_log("Error al crear receta: " . $e->getMessage());
                return false;
            }
        }
        
        
        public function createBlog($title, $intro, $content, $image, $author_id) {
            $query = "INSERT INTO blogs (title, intro, content, image, author_id, created_at) 
                    VALUES (:title, :intro, :content, :image, :author_id, NOW())";
            $resultado = $this->conexion->conectar()->prepare($query);
            $resultado->bindParam(':title', $title);
            $resultado->bindParam(':intro', $intro);
            $resultado->bindParam(':content', $content);
            $resultado->bindParam(':image', $image, PDO::PARAM_LOB);
            $resultado->bindParam(':author_id', $author_id);
            return $resultado->execute();
        }


        public function getFilteredRecipes($filters = []) {
            $query = "SELECT recipes.*, users.username 
                    FROM recipes
                    JOIN users ON recipes.user_id = users.id
                    WHERE 1=1"; 

            $params = [];
            
            if (!empty($filters['difficulty'])) {
                $query .= " AND recipes.difficulty = :difficulty";
                $params[':difficulty'] = $filters['difficulty'];
            }
            
            if (!empty($filters['category'])) {
                $query .= " AND recipes.category = :category";
                $params[':category'] = $filters['category'];
            }
            
            $resultado = $this->conexion->conectar()->prepare($query);
            $resultado->execute($params);
            
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getAllRecipes() {
            try {
                $query = "SELECT * FROM recipes";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->execute();
                return $resultado->fetchAll(PDO::FETCH_ASSOC); 
            } catch (PDOException $e) {
                error_log("Error al obtener recetas: " . $e->getMessage());
                return [];
            }
        }

        public function getAllUsers() {
            $query = "SELECT * FROM users";
            $resultado = $this->conexion->conectar()->prepare($query);
            $resultado->execute();
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAllBlogs() {
            $query = "SELECT blogs.*, users.username 
                    FROM blogs 
                    JOIN users ON blogs.author_id = users.id 
                    ORDER BY blogs.created_at DESC";
            $resultado = $this->conexion->conectar()->prepare($query);
            $resultado->execute();
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getRecipe($id) {
            $query = "SELECT * FROM recipes WHERE id = :id";
            $resultado = $this->conexion->conectar()->prepare($query);
            $resultado->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado->execute();

            return $resultado->fetch(PDO::FETCH_ASSOC);
        }

        public function getUser($id){
            $query = "SELECT * FROM users WHERE id = :id";
            $resultado = $this->conexion->conectar()->prepare($query);
            $resultado->bindParam(':id', $id);
            $resultado->execute();
            $respuesta = $resultado->fetch(PDO::FETCH_ASSOC);

            return $respuesta;
        }

        public function getBlog($id) {
            $query = "SELECT blogs.*, users.username 
                    FROM blogs 
                    JOIN users ON blogs.author_id = users.id 
                    WHERE blogs.id = :id";
            $resultado = $this->conexion->conectar()->prepare($query);
            $resultado->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado->execute();

            return $resultado->fetch(PDO::FETCH_ASSOC);
        }


        public function updateUserRole($userId, $newRole) {
            $query = "UPDATE users SET role = :role WHERE id = :id";
            $resultado = $this->conexion->conectar()->prepare($query);
            $resultado->bindParam(':role', $newRole);
            $resultado->bindParam(':id', $userId);
            return $resultado->execute();
        }

        public function updateRecipe($id, $title, $category, $difficulty, $ingredients, $instructions, $image) {
            try {
                $query = "UPDATE recipes 
                          SET title = :title, 
                              category = :category, 
                              difficulty = :difficulty, 
                              ingredients = :ingredients, 
                              instructions = :instructions, 
                              image = :image
                          WHERE id = :id";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->bindParam(':id', $id, PDO::PARAM_INT);
                $resultado->bindParam(':title', $title);
                $resultado->bindParam(':category', $category);
                $resultado->bindParam(':difficulty', $difficulty);
                $resultado->bindParam(':ingredients', $ingredients);
                $resultado->bindParam(':instructions', $instructions);
                $resultado->bindParam(':image', $image, PDO::PARAM_LOB);
        
                return $resultado->execute();
            } catch (PDOException $e) {
                error_log("Error al actualizar la receta: " . $e->getMessage());
                return false;
            }
        }

        public function updateBlog($id, $title, $intro, $content, $image) {
            try {
                $query = "UPDATE blogs 
                        SET title = :title, 
                            intro = :intro,
                            content = :content, 
                            image = :image
                        WHERE id = :id";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->bindParam(':id', $id, PDO::PARAM_INT);
                $resultado->bindParam(':title', $title);
                $resultado->bindParam(':intro', $intro);
                $resultado->bindParam(':content', $content);
                $resultado->bindParam(':image', $image);

                return $resultado->execute();
            } catch (PDOException $e) {
                error_log("Error al actualizar el blog: " . $e->getMessage());
                return false;
            }
        }


        public function deleteUser($userId) {
            $query = "DELETE FROM users WHERE id = :id";
            $resultado = $this->conexion->conectar()->prepare($query);
            $resultado->bindParam(':id', $userId);
            return $resultado->execute();
        }


        public function deleteRecipe($recipe_id) {
            try {
                $query = "DELETE FROM recipes WHERE id = :id";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->bindParam(':id', $recipe_id);
                
                return $resultado->execute(); 
            } catch (PDOException $e) {

                return false;
            }
        }

        public function deleteBlog($blog_id) {
            try {
                $query = "DELETE FROM blogs WHERE id = :id";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->bindParam(':id', $blog_id, PDO::PARAM_INT);
                return $resultado->execute();
            } catch (PDOException $e) {
                error_log("Error al eliminar el blog: " . $e->getMessage());
                return false;
            }
        }
        public function saveComment($user_id, $recipe_id, $content) {
            try {

                $query = "INSERT INTO comments (content, user_id, recipe_id, created_at) 
                        VALUES (:content, :user_id, :recipe_id, NOW())";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->bindParam(':content', $content);
                $resultado->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $resultado->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);

                return $resultado->execute(); 
            } catch (PDOException $e) {
                error_log("Error al guardar comentario: " . $e->getMessage());
                return false; 
            }
        }

        public function saveBlogComment($user_id, $blog_id, $content) {
            try {
                $query = "INSERT INTO comments (content, user_id, blog_id, created_at) 
                        VALUES (:content, :user_id, :blog_id, NOW())";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->bindParam(':content', $content);
                $resultado->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $resultado->bindParam(':blog_id', $blog_id, PDO::PARAM_INT);

                return $resultado->execute();
            } catch (PDOException $e) {
                error_log("Error al guardar comentario de blog: " . $e->getMessage());
                return false;
            }
        }

        public function getCommentsByRecipe($recipe_id) {
            try {
                $query = "SELECT comments.*, users.username 
                        FROM comments
                        JOIN users ON comments.user_id = users.id
                        WHERE comments.recipe_id = :recipe_id
                        ORDER BY comments.created_at DESC";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
                $resultado->execute();

                return $resultado->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Error al obtener comentarios: " . $e->getMessage());
                return [];
            }
        }
        
        public function getCommentsByBlog($blog_id) {
            $query = "SELECT c.*, u.username 
                      FROM comments c 
                      JOIN users u ON c.user_id = u.id 
                      WHERE c.blog_id = :blog_id
                      ORDER BY c.created_at ASC";
            $resultado = $this->conexion->conectar()->prepare($query);
            $resultado->bindParam(':blog_id', $blog_id, PDO::PARAM_INT);
            $resultado->execute();
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        }
        

        public function saveOrUpdateRating($recipe_id, $user_id, $rating) {
            try {
                $query = "INSERT INTO ratings (recipe_id, user_id, rating) 
                        VALUES (:recipe_id, :user_id, :rating)
                        ON DUPLICATE KEY UPDATE rating = :rating";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
                $resultado->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $resultado->bindParam(':rating', $rating, PDO::PARAM_INT);

                return $resultado->execute();
            } catch (PDOException $e) {
                error_log("Error al guardar o actualizar calificación: " . $e->getMessage());
                return false;
            }
        }

        public function getAverageRating($recipe_id) {
            try {
                $query = "SELECT AVG(rating) AS average_rating 
                        FROM ratings WHERE recipe_id = :recipe_id";
                $resultado = $this->conexion->conectar()->prepare($query);
                $resultado->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
                $resultado->execute();

                $result = $resultado->fetch(PDO::FETCH_ASSOC);
                return $result['average_rating'] ?? 0; 
            } catch (PDOException $e) {
                error_log("Error al obtener promedio de calificaciones: " . $e->getMessage());
                return 0;
            }
        }
        
    }

?>
