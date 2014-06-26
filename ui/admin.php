<div class="wrap">
	<h2>ESPN Feed</h2>
	
	<p>To get started, you must enter your API Key</p>
	
	<form method="post" action="<?php echo admin_url('options-general.php?page='. $_GET['page']); ?>">
	
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="api_key">API Key</label></th>
					<td>
						<input name="api_key" type="text" id="api_key" value="<?php echo $this->get_api_key(); ?>" class="regular-text <?php if($this->test_api()): ?>is-ok<?php endif; ?>">
						<p class="description">This value comes from the ESPN developer dashboard.</p>
					</td>
				</tr>
			</tbody>
		</table>
	
		<input type="submit" class="button button-primary" value="Authorize App" />
	</form>

</div>
