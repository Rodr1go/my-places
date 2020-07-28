<?php

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $local =[
      "id" => $_POST['id'],
      "nome" => $_POST['nome'],
      "cep" => $_POST['cep'],
      "logradouro" => $_POST['logradouro'],
      "complemento" => $_POST['complemento'],
      "numero" => $_POST['numero'],
      "bairro" => $_POST['bairro'],
      "uf" => $_POST['uf'],
      "cidade" => $_POST['cidade'],
      "data" => $_POST['data']
    ];

    $sql = "UPDATE locais 
            SET id = :id,
              nome = :nome,
              cep = :cep, 
              logradouro = :logradouro,
              complemento = :complemento,
              numero = :numero,
              bairro = :bairro,
              uf = :uf,
              cidade = :cidade,  
              data = :data 
            WHERE id = :id";
  
  $statement = $connection->prepare($sql);
  $statement->execute($local);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM locais WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    
    $local = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Algo deu errado!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['nome']); ?> Atualizado com sucesso.</blockquote>
<?php endif; ?>

<div class="card">
  <div class="card-content">
    <form method="post">
      <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
      <?php foreach ($local as $key => $value) : ?>
        <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
        <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" 
              value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?> required>
      <?php endforeach; ?> 
      <input class="waves-effect waves-light btn-small" type="submit" name="submit" value="Atualizar">
    </form>    
  </div>
</div>


<?php require "templates/footer.php"; ?>
