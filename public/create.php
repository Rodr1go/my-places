<?php

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_locale = array(
      "nome" => $_POST['nome'],
      "cep" => $_POST['cep'],
      "logradouro" => $_POST['logradouro'],
      "complemento" => $_POST['complemento'],
      "numero" => $_POST['numero'],
      "bairro" => $_POST['bairro'],
      "uf" => $_POST['uf'],
      "cidade" => $_POST['cidade']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "locais",
      implode(", ", array_keys($new_locale)),
      ":" . implode(", :", array_keys($new_locale))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_locale);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['nome']); ?> Adicionado com sucesso!</blockquote>
  <?php endif; ?>
  
  <div class="card">
    <div class="card-content">    
      <h2>Adicionar um local</h2>

      <form method="post">
        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" required>
        <label for="cep">Cep</label>
        <input type="text" name="cep" id="cep" required>
        <label for="logradouro">Logradouro</label>
        <input type="text" name="logradouro" id="logradouro" required>
        <label for="complemento">Complemento</label>
        <input type="text" name="complemento" id="complemento" required>
        <label for="numero">Número</label>
        <input type="text" name="numero" id="numero" required>
        <label for="bairro">Bairro</label>
        <input type="text" name="bairro" id="bairro" required>
        <label for="uf">UF</label>
        <input type="text" name="uf" id="uf" required>
        <label for="cidade">Cidade</label>
        <input type="text" name="cidade" id="cidade" required>
        <input type="submit" class="waves-effect waves-light btn-small" name="submit" value="Salvar">
      </form>
    </div>
  </div>


<?php require "templates/footer.php"; ?>
