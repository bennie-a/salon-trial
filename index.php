<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

JLoader::import('joomla.filesystem.file');

// Check modules
$showRightColumn = ($this->countModules('position-3') or $this->countModules('position-6') or $this->countModules('position-8'));
$showbottom      = ($this->countModules('position-9') or $this->countModules('position-10') or $this->countModules('position-11'));
$showleft        = ($this->countModules('position-4') or $this->countModules('position-7') or $this->countModules('position-5'));

if ($showRightColumn == 0 and $showleft == 0)
{
	$showno = 0;
}

JHtml::_('behavior.framework', true);

// Get params
$color          = $this->params->get('templatecolor');
$logo           = $this->params->get('logo');
$navposition    = $this->params->get('navposition');
$headerImage    = $this->params->get('headerImage');
$doc            = JFactory::getDocument();
$app            = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$config         = JFactory::getConfig();
$bootstrap      = explode(',', $templateparams->get('bootstrap'));
$jinput         = JFactory::getApplication()->input;
$option         = $jinput->get('option', '', 'cmd');

if (in_array($option, $bootstrap))
{
	// Load optional rtl Bootstrap css and Bootstrap bugfixes
	JHtml::_('bootstrap.loadCss', true, $this->direction);
}

$doc->addStyleSheet($this->baseurl . '/templates/system/css/system.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/position.css', $type = 'text/css', $media = 'screen,projection');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/layout.css', $type = 'text/css', $media = 'screen,projection');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/print.css', $type = 'text/css', $media = 'print');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/general.css', $type = 'text/css', $media = 'screen,projection');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/' . htmlspecialchars($color) . '.css', $type = 'text/css', $media = 'screen,projection');

if ($this->direction == 'rtl')
{
	$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template_rtl.css');
	if (file_exists(JPATH_SITE . '/templates/' . $this->template . '/css/' . $color . '_rtl.css'))
	{
		$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/' . htmlspecialchars($color) . '_rtl.css');
	}
}

JHtml::_('bootstrap.framework');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/javascript/md_stylechanger.js', 'text/javascript');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/javascript/respond.src.js', 'text/javascript');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/javascript/template.js', 'text/javascript');

// Check for a custom CSS file
$userCss = JPATH_SITE . '/templates/' . $this->template . '/css/user.css';

if (file_exists($userCss) && filesize($userCss) > 0)
{
	$doc->addStyleSheetVersion('templates/' . $this->template . '/css/user.css');
}

?>

<!DOCTYPE html>
	<head>
		<?php require __DIR__ . '/jsstrings.php';?>

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes"/>
		<meta name="HandheldFriendly" content="true" />
		<meta name="apple-mobile-web-app-capable" content="YES" />

		<jdoc:include type="head" />

		<!--[if IE 7]>
		<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet" type="text/css" />
		<![endif]-->
	</head>
	<body id="shadow">
		<?php if ($color == 'image'):?>
			<style type="text/css">
				.logoheader {
					background:url('<?php echo $this->baseurl . '/' . htmlspecialchars($headerImage); ?>') no-repeat right;
				}
				body {
					background: <?php echo $templateparams->get('backgroundcolor'); ?>;
				}
			</style>
		<?php endif; ?>

		<header id="header">
				<jdoc:include type="modules" name="position-1" />
				<h1><?php echo htmlspecialchars($templateparams->get('sitetitle')); ?></h1>
			<ul class="skiplinks">
				<li><a href="#main" class="u2"><?php echo JText::_('TPL_BEEZ3_SKIP_TO_CONTENT'); ?></a></li>
				<li><a href="#nav" class="u2"><?php echo JText::_('TPL_BEEZ3_JUMP_TO_NAV'); ?></a></li>
				<?php if ($showRightColumn) : ?>
					<li><a href="#right" class="u2"><?php echo JText::_('TPL_BEEZ3_JUMP_TO_INFO'); ?></a></li>
				<?php endif; ?>
			</ul>
			<h2 class="unseen"><?php echo JText::_('TPL_BEEZ3_NAV_VIEW_SEARCH'); ?></h2>
			<h3 class="unseen"><?php echo JText::_('TPL_BEEZ3_NAVIGATION'); ?></h3>
		</header><!-- end header -->
		<div id="all">
			<div id="back">
				<main id="<?php echo $showRightColumn ? 'contentarea2' : 'contentarea'; ?>">
					<jdoc:include type="component" />
					<?php if ($navposition == 'center' and $showleft) : ?>
						<nav class="left <?php if ($showRightColumn == null) { echo 'leftbigger'; } ?>" id="nav" >

							<jdoc:include type="modules" name="position-7"  style="beezDivision" headerLevel="3" />
							<jdoc:include type="modules" name="position-4" style="beezHide" headerLevel="3" state="0 " />
							<jdoc:include type="modules" name="position-5" style="beezTabs" headerLevel="2"  id="3" />

						</nav><!-- end navi -->
					<?php endif; ?>
					<div id="footer-image">
						<jdoc:include type="modules" name="position-5"/>
					</div>
					<div id="footer-outer">
						<?php if ($showbottom) : ?>
							<div id="footer-inner" >
								<ul id="bottom">
									<li>
										<jdoc:include type="modules" name="position-9" style="beezDivision" headerlevel="3" />
									</li>
									<li>
										<jdoc:include type="modules" name="position-10" style="beezDivision" headerlevel="3" />
									</li>
									<li>
										<jdoc:include type="modules" name="position-11" style="beezDivision" headerlevel="3" />
									</li>
								</ul>
							</div>
						<?php endif; ?>
				<div id="footer-sub">
							<footer id="footer">
								<jdoc:include type="modules" name="position-12" />
								<div>
									<jdoc:include type="modules" name="position-14" />
								</div>
							</footer><!-- end footer -->
						</div>
					</div>
				</main> <!-- end contentarea -->
			</div><!-- back -->
		</div><!-- all -->

		<jdoc:include type="modules" name="debug" />
	</body>
</html>
