<?php

require "../config.php";
require "../common.php";

  $success = null;

  if (isset($_POST["submit"])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
      $connection = new PDO($dsn, $username, $password, $options);
    
      $id = $_POST["submit"];

      $sql = "DELETE FROM locais WHERE id = :id";

      $statement = $connection->prepare($sql);
      $statement->bindValue(':id', $id);
      $statement->execute();

      $success = "Deletado com sucesso!";
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT id, nome, data FROM locais";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
?>
<?php require "templates/header.php"; ?>

<?php  
  if ($result && $statement->rowCount() > 0) { ?>
    <div class="card">
      <div class="card-content">
        <a class="waves-effect waves-light btn-small" href="create.php"><i class="material-icons left">add_box</i> Novo</a>
        <hr>
        <?php if ($success) echo $success; ?>
        <form method="post">
          <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
          <table class="striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Data</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($result as $row) : ?>
              <tr>
                <td><?php echo escape($row["id"]); ?></td>
                <td><?php echo escape($row["nome"]); ?></td>
                <td><?php echo escape($row["data"]); ?></td>
                <td>
                  <a class="btn waves-light" href="update.php?id=<?php echo escape($row["id"]); ?>">
                    <i class="material-icons center">create</i>
                  </a>
                  <button type="submit" class="btn waves-light  red lighten-2" name="submit" value="<?php echo escape($row["id"]); ?>">
                    <i class="material-icons center">delete</i>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </form>  
      </div>
    </div> 
  <?php } else { ?>
    <blockquote>Nenhum resultado encontrado!</blockquote>
  <?php } 
?> 

<?php require "templates/footer.php"; ?>