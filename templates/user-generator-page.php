<div class="wrap"><h2>User generator</h2>
	<p><?php _e('Create random users for testing purposes', 'ctrl-user-generator'); ?></p>

	<form action="" method="post" id="generate_users_form">
		<?php wp_nonce_field( 'generate_users' ); ?>
		<input type="hidden" name="action" value="generate_users">

		<table class="form-table">
			<tbody>
			<tr>
				<th>
					<label for="iterations"><?php _e('How many users', 'ctrl-user-generator')?></label></th>
				<td>
					<select name="iterations" id="iterations">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="10">10</option>
						<option value="15">15</option>
						<option value="20">20</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="user-role"><?php _e('Select the role of the newly created users', 'ctrl-user-generator'); ?></label></th>
				<td>
					<?php $roles = get_editable_roles(); ?>


					<select name="user-role" id="user-role">
						<?php foreach ( $roles as $role ) : ?>
							<option
								value="<?php echo strtolower( $role['name'] ); ?>"><?php echo $role['name']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th>
					<label for="user-category"><?php _e('Select the user category', 'ctrl-user-generator'); ?></label>
				</th>
				<td>
					<select name="user-category" id="user-category">
						<option value="starwars">Star Wars</option>
						<option value="simpsons">The Simpsons</option>
						<option value="gurus">WordPress guru's</option>
					</select>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" value="<?php _e('Start generating users!', 'ctrl-user-generator'); ?>" class="button button-primary button-large">
				</td>
			</tr>
			</tbody>
		</table>
	</form>
	<div class="message"><p></p></div>
</div>


