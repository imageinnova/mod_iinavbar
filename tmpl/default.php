<?php 
defined('_JEXEC') or die;

$site    = $app->get('baseurl');
$sitename = $app->get('sitename');
$logo = $sitename;
if ($params->get('logoFile')):
	$logo = '<img src="' . JUri::root() . $params->get('logoFile') . '" alt="' . $sitename . '" />';
elseif ($params->get('sitetitle')):
	$logo = htmlspecialchars($params->get('sitetitle'));
endif;
?>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header visible-xs">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo $site; ?>"><?php echo $logo; ?></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav"
				<?php
				$tag = '';
				
				if ($params->get('tag_id') != null):
					$tag = $params->get('tag_id') . '';
					echo ' id="' . $tag . '"';
				endif;
				?>
			>
			<?php
			foreach ($list as $i => &$item):
				$class = 'item-' . $item->id;

				if (($item->id == $active_id) OR ($item->type == 'alias' AND $item->params->get('aliasoptions') == $active_id)):
					$class .= ' current';
				endif;
				
				if (in_array($item->id, $path)):
					$class .= ' active';
				elseif ($item->type == 'alias'):
					$aliasToId = $item->params->get('aliasoptions');
			
					if (count($path) > 0 && $aliasToId == $path[count($path) - 1]):
						$class .= ' active';
					elseif (in_array($aliasToId, $path)):
						$class .= ' alias-parent-active';
					endif;
				endif;

				if ($item->type == 'separator'):
					$class .= ' divider';
				endif;
								
				if ($item->deeper):
					$class .= ' deeper';
				endif;
				
				$parent = false;	// carried to the inner element
				if ($item->parent):
					$class .= ' dropdown parent';
					$parent = true;
				endif;
				
				if (!empty($class)):
					$class = ' class="' . trim($class) . '"';
				endif;
							
				echo '<li' . $class . '>';

				// Render the menu item.
				switch ($item->type) :
					case 'separator':
					case 'url':
					case 'component':
					case 'heading':
						require JModuleHelper::getLayoutPath('mod_iinavbar', 'default_' . $item->type);
						break;
			
					default:
						require JModuleHelper::getLayoutPath('mod_iinavbar', 'default_url');
						break;
				endswitch;

				// The next item is deeper.
				if ($item->deeper)
				{
					echo '<ul class="dropdown-menu" role="menu">';
				}
				elseif ($item->shallower)
				{
					// The next item is shallower.
					echo '</li>';
					echo str_repeat('</ul></li>', $item->level_diff);
				}
				else
				{
					// The next item is on the same level.
					echo '</li>';
				}
			endforeach;
			?>
			</ul>
		</div> <!-- navbar-collapse -->
	</div> <!-- container-fluid -->
</nav>
