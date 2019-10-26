<form method="post" action="index.php#contact">
    <div>
        <label for="lastname">Nom : </label>
        <input type="text" name="lastname" id="lastname" value="<?php if(isset($data['lastname'])) echo $data['lastname']; ?>" placeholder="Doe" required>
        <span class="error"><?php if(isset($errors['lastnameErr'])) echo $errors['lastnameErr'];?></span>
    </div>
    <div>
        <label for="firstname">Prénom : </label>
        <input type="text" name="firstname" id="firstname" value="<?php if(isset($data['firstname'])) echo $data['firstname']; ?>" placeholder="John" required>
        <span class="error"><?php if(isset($errors['firstnameErr'])) echo $errors['firstnameErr'];?></span>
    </div>
    <div>
        <label for="email">E-mail: </label>
        <input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="johndoe@example.fr" required>
        <span class="error"n><?php if(isset($errors['emailErr'])) echo $errors['emailErr'];?></span>
    </div>
    <div>
        <label for="message">Message : </label>
        <textarea name="message" id="message" required><?php if(isset($_POST['message'])) echo $_POST['message']; ?></textarea>
        <span class="error"n><?php if(isset($errors['messageErr'])) echo $errors['messageErr'];?></span>
    </div>
    <div class="button">
        <button type="submit" name="envoyer" value="submit">Envoyer</button>
    </div>
</form>