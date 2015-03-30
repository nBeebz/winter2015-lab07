<div class="row">
	<h1>Order for {customer}</h1>
	{burgers}
		<hr>
		<h3>Burger #{num}</h3>
		<p>Patty: {patty}</p>
		<p>Top Cheese: {topCheese}</p>
		<p>Bottom Cheese: {botCheese}</p>
		Toppings
		<ul>
			{toppings}
			<li>{name}</li>
			{/toppings}
		</ul>
		Sauces
		<ul>
			{sauces}
			<li>{name}</li>
			{/sauces}
		</ul>
		<p>Price: {price}</p>
	{/burgers}
	<h4>Total: {total}</h4>
</div>