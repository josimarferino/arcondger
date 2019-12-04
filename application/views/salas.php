<?php include 'layout/header.php' ?>

<div class="ui grid">

<form class="ui form column stackable grid" action="<?=site_url()?>/salas/salvar" method="post">


<?=$this->session->flashdata('error')?>
<?=$this->session->flashdata('success')?>
<?=$this->session->flashdata('warning')?>

<input type="hidden" name="id" value="<?=val($dados,'id')?>">
<b><label style="font-size: 20px"> Salas </label><b>
<br>
<br>
<div class="field">
	<label>IP
		<input type="text" name="ip" value="<?=val($dados,'ip')?>">
		<?=form_error('ip')?>
	</label>
</div>


<div class="field">
	<button  class="ui blue button" type="submit">Salvar</button>
	<a class="ui button" href="<?=site_url()?>/salas">Novo</a>
</div>

</form>


</div>






<table class="ui celled table">
	<thead>
		<tr>
			<th>Editar</th>
			<th>Deletar</th>
			<th>IP</th>
			<th>Número da Sala</th>
			<th>Marca do Ar</th>
			<th>Tem Pessoas</th>
			<th>Ar Ligado</th>
			
		</tr>
	</thead>
	<tbody>
	
<?php

foreach($listaPaginada["data"] as $ln){
	
	print "<tr>";
	
	print "<td><a href='".site_url()."/salas/index/{$ln->id}'> Editar </a></td>";
	
	print "<td><a onclick='confirmDelete(\"".site_url()."/salas/deletar/{$ln->id}\")'> Deletar </a></td>";
	
	
	
	print "<td>{$ln->ip}</td>";
	
	
	if ($ln->captura_dados != false){
		
		$i = 0;
		foreach($ln->captura_dados as $info){
			
			$i++;
			print "<td>{$info->num_sala }</td>";
			
			print "<td>{$info->marca }</td>";
			
			if ($info->tem_pessoas){
				$tem_pessoas = 'sim.png';
			} else {
				$tem_pessoas = 'nao.png';
			}
			
			print "<td> <img src='".base_url()."static/$tem_pessoas'></td>";
				
			
			#print "<td>{$info->ligado }</td>";

			if ($info->ligado){
				$ligado = 'on.ico'; 
				$href = site_url()."/salas/desligarArCond/{$ln->ip}"; 
			} else {
				$ligado = 'off.ico';
				$href = site_url()."/salas/ligarArCond/{$ln->ip}"; 
			}
			
			print "<td> <a href='$href'><img src='".base_url()."static/$ligado'></a> </td>";

			if (count($ln->captura_dados) != $i){
				print "</tr><tr><td colspan='3'></td>";
			}
		}
	
	} else {
		print "<td colspan='4'>Arduino Não Encontrado</td>";
		
	}

	
	
	print "</tr>";
}

#paginacao
$this->pagination->initialize($listaPaginada);
?>
	<tfoot>
	<tr>
		<th colspan="8">
		<span class="ui label">
			Total: <?=$listaPaginada["total_rows"]?>
		</span>
		<?php if ($listaPaginada["page_max"] > 1): ?>
			<div class="ui right floated pagination menu">
				<?=$this->pagination->create_links()?>
			</div>
		<?php endif; ?>
		</th>
	</tr>
	</tfoot>
</tbody>
</table>

<?php
include 'layout/bottom.php';
?>