<?php
    echo '
    <header>
		<div class="container">
			<h1 class="logo">Banca Futuro</h1>
			<nav>
				<ul>
					<li><a href="/php/bank/home">Home</a></li>
					<li><a href="/php/bank/crea-conto">Crea nuovo Conto</a></li>
					<li><a href="/php/bank/carta-credito">Carte</a></li>
					<li><a href="/php/bank/bonifico">Bonifici</a></li>
					<li><a href="/php/bank/investimenti">Investimenti</a></li>';

						if($_SESSION['role'] == 'admin')
						{
							echo '<li><a href="/php/bank/admin">Admin</a></li>';
						}
					echo'
					<li><a href="../script/logout.php">Logout</a></li>
				</ul>
			</nav>
		</div>
	</header>
    ';
?>