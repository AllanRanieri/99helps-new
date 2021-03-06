<div class="container-fluid">
	<div class="card-deck">			
		<div class="card-body">
			<?php
				if (isset($_GET['add'])) {
					echo '<h4 class="card-title">Dados pessoais</h4>';
				}
			?>
			<form method="POST" enctype="multipart/form-data" name="formCadastro">
				<input type="hidden" name="id" value="<?=$id?>">
				<div class="row">
					<div class="form-group col-12">
						<label for="nome">Nome</label>
						<input type="text" class="form-control" id="nome" name="nome" aria-describedby="nome" placeholder="Ex: Amiguinho Feliz" value="<?=$this->nome?>">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-12">
						<label for="sobrenome">Sobrenome</label>
						<input type="text" class="form-control" id="sobrenome" name="sobrenome" aria-describedby="sobrenomel" placeholder="Ex: Amiguinho Feliz" value="<?=$this->sobrenome?>">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-2">
						<label for="sexo">Sexo</label>
						<select class="form-control" id="sexo" name="sexo">
							<option>Masculino</option>
							<option>Feminino</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="nascimento">Nascimento</label>
						<input type="date" class="form-control" id="nascimento" name="datanascimento" aria-describedby="emailHelp" value="<?=$this->datanascimento?>">
					</div>
					<?php
						if (!isset($_GET['edit'])) {
					?>
					<div class="form-group col-md-4">
						<label for="imagem_perfil">Foto do perfil:</label>
						<input type="file" class="form-control-file" id="imagem_perfil" name="fileToUpload" aria-describedby="fileHelp" value="<?=$this->imagem_perfil?>">
					</div>
					<?php
						}
					?>
				</div>
				<div class="row">
					<div class="form-group col-12 col-md-6">
						<label for="estado">Estado</label>
						<select class="custom-select form-control" name="estado" value="<?=$this->estado?>">
							<option selected>Selecione o estado</option>
							<?php
								$sqlEstado = "SELECT distinct(estado) FROM cidades";	
								$consultaEstado = mysql_query($sqlEstado);
								while ($rsEstado = mysql_fetch_array($consultaEstado)) {
									if ($rsEstado['estado']==$this->estado) {
										echo '<option value="'.$rsEstado['id'].'" selected>'.$rsEstado['estado'].'</option>';
									} else {
										echo '<option value="'.$rsEstado['id'].'">'.$rsEstado['estado'].'</option>';
									}
								}
							?>
						</select>
					</div>
					<div class="form-group col-12 col-md-6">
						<label for="cidade">Cidade</label>
						<select class="custom-select form-control" name="fk_cidades" value="<?=$this->fk_cidades?>">
							<option selected>Selecione a cidade</option>
							<?php
								$sqlCity = "SELECT * FROM cidades";	
								$consultaCity = mysql_query($sqlCity);
								while ($rsCity = mysql_fetch_array($consultaCity)) {
									if ($rsCity['id']==$this->fk_cidades) {
										echo '<option value="'.$rsCity['id'].'" selected>'.$rsCity['cidadenome'].'</option>';
									} else {
										echo '<option value="'.$rsCity['id'].'">'.$rsCity['cidadenome'].'</option>';
									}
								}
							?>
						</select>
					</div>
				</div>
				<!-- INTERESSES -->
				<div class="row">
					<div class="form-group col-12">
						<label for="interesses">Interesses:</label><br>
						<?php
							// todos os interesses
							if (isset($_GET['edt'])) {

								$ids_int_user = array(); 
								$sql = "SELECT fk_interesse FROM interesses_usuario WHERE fk_usuario = " . $_GET['edt'];
								$burro = mysql_query($sql);

								while ($ids_int_user2 = mysql_fetch_array($burro)) {
									$ids_int_user[]  = $ids_int_user2['fk_interesse'];
								}

							} else {
								$ids_int_user = array();
							}

							$sqlInteresses = "SELECT * FROM interesses";
							$consultaInteresses = mysql_query($sqlInteresses);

							while ($interesses = mysql_fetch_array($consultaInteresses)) {

								// faz o checked onde o interesse listado esta dentro do vetor de interesses da pessoa
								if (in_array($interesses['id'], $ids_int_user)) {
									$podeChecar = "checked";
								} else {
									$podeChecar = "";
								}

								echo '
								<input type="checkbox" '.$podeChecar.' name="interesses['.$interesses['id'].']" value="' . $interesses['id'].'" id="interesses['.$interesses['id'].']">
								<label for="interesses['.$interesses['id'].']" >' . $interesses['nome'].'</label> <br>';
							}

						?>
						<small id="causa-defendidaHelp" class="form-text text-muted">Você pode escolher quantos interesses quiser</small>
					</div>	
				</div>
				<div class="row">
					<div class="form-group col-12">
						<label for="exampleTextarea">Rápida descrição sobre você!!!!</label>
						<textarea class="form-control" id="exampleTextarea" rows="3" name="descricao"><?=$this->descricao?></textarea>
					</div>
				</div>
				<?php
					if (isset($_GET['add'])) {
						echo '<h4 class="card-title">Segurança</h4>';
						require_once("teste_usuario_seguranca.php");
					}
				?>
				<div class="row">
					<?php
						if (!isset($_GET['edt'])) {
					?>
						<div class="form-group col-12 form-check">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input">
								Concordo com os termos do site!!
							</label>
						</div>
					<?php
						}
					?>
				</div>
				<div class="row">
					<div class="form-group col-12">
						<input type="submit" type="button" class="btn btn-success" name="cadastro" value="Cadastrar">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>