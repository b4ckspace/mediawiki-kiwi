<?php
/**
 * Simple: A lightweight skin with a simple white-background sidebar and no
 * top bar.
 *
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/** */
#require_once( dirname(__FILE__) . '/MonoBook.php' );
$wgValidSkinNames['kiwi'] = 'kiwi';

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @ingroup Skins
 */
class SkinKiwi extends SkinTemplate {
	var $skinname = 'kiwi', $stylename = 'kiwi',
		$template = 'KiwiTemplate', $useHeadElement = true;

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

	#	$out->addModuleStyles( 'skins.kiwi' );

		/* Add some userprefs specific CSS styling */
		$rules = array();
		$underline = "";

        $out->addMeta('flattr:id', '456799');
		$out->addStyle( 'kiwi/shared.css', 'screen' );
		$out->addStyle( 'kiwi/commonContent.css', 'screen' );
		$out->addStyle( 'kiwi/main.css?rev=2', 'screen' );
		$out->addStyle( 'kiwi/print.css', 'print' );
	//	$out->addStyle( 'kiwi/mobile.css', 'all and (max-device-width: 480px)' );

#		$out->addStyle('kiwi/combined_shared_common_main.min.css', 'screen');

		if ( $this->getUser()->getOption( 'underline' ) < 2 ) {
			$underline = "text-decoration: " . $this->getUser()->getOption( 'underline' ) ? 'underline !important' : 'none' . ";";
		}

		/* Also inherits from resourceloader */
		if( !$this->getUser()->getOption( 'highlightbroken' ) ) {
			$rules[] = "a.new, a.stub { color: inherit; text-decoration: inherit;}";
			$rules[] = "a.new:after { color: #CC2200; $underline;}";
			$rules[] = "a.stub:after { $underline; }";
		}
		$style = implode( "\n", $rules );
		$out->addInlineStyle( $style, 'flip' );

	}
}


/**
 * @todo document
 * @ingroup Skins
 */
class KiwiTemplate extends BaseTemplate {

    function getPageURL( $title ) {
        $title = Title::newFromText( $title );

        if( !$title ) {
            return '#';    
        }

        return $title->getFullUrl();
    }
	/**
	 * Template filter callback for MonoBook skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {

		$skin = $this->data['skin'];

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();
		$this->html( 'headelement' );

        $curTitle = false;
        if( isset( $this->data['title'] ) ) {
            $curTitle = $this->data['title'];
        }
?>

    <div id="bs-wrapper">

        <div id="bs-head">
            <div id="bs-logo">
                <a href="<?php echo $this->getPageURL('Main_Page'); ?>"><img width="400" height="70" src="<?php echo $skin->getSkinStylePath('images/backspace_logo.png') ?>" alt="Backspace e.V - Hackerspace Bamberg"></a>
            </div>

            <div id="bs-search">
                <form action="<?php $this->text('wgScript') ?>" id="searchform">
                    <input type='hidden' name="title" value="<?php $this->text('searchtitle') ?>"/>
                    <?php echo $this->makeSearchInput(array( "id" => "searchInput", "placeholder" => "Suchen" )); ?>
                    <?php echo $this->makeSearchButton("go", array( "id" => "searchGoButton", "class" => "searchButton" )); ?>
                </form>
                
            </div>
        </div>

        <div id="bs-navigation">
            <ul id="bs-menu" class="menu">
                <li class="first leaf"><a href="<?php echo $this->getPageURL('Hauptseite'); ?>" title="Startseite">Startseite</a></li>
                <li class="nolink expandable">
                    <span>Wiki</span>
                    <ul class="menu">
                        <li class="first leaf"><a href="<?php echo $this->getPageURL('Special:Recentchanges'); ?>">Letzte Änderungen</a></li>
                        <li class="leaf"><a href="<?php echo $this->getPageURL('Special:Upload'); ?>">Datei hochladen</a></li>
                        <li class="nolink expandable sub-sub-menu">
                            <span>User</span>
                            <ul class="menu" <?php $this->html('userlangattributes') ?>>
                                <?php foreach($this->getPersonalTools() as $key => $item) { ?>
                                    <?php echo $this->makeListItem($key, $item); ?>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="last leaf"><a href="<?php echo $this->getPageURL('Special:Specialpages'); ?>">Spezialseiten</a></li>
                    </ul>
                </li>
                <li class="expandable">
                    <a href="<?php echo $this->getPageURL('Projekte'); ?>">Projekte</a>
                    <ul class="menu">
                        <li class="first leaf"><a href="<?php echo $this->getPageURL('Projekte'); ?>">Alle</a></li>
                        <li class="leaf"><a href="<?php echo $this->getPageURL('Hardware'); ?>">Hardware</a></li>
                        <li class="leaf"><a href="<?php echo $this->getPageURL('Software'); ?>">Software</a></li>
                        <li class="leaf"><a href="<?php echo $this->getPageURL('Infrastruktur'); ?>">Infrastruktur</a></li>
                        <li class="last leaf"><a href="<?php echo $this->getPageURL('Sonstiges'); ?>">Sonstiges</a></li>
                    </ul>
                </li>
                <li class="expandable">
                    <a href="<?php echo $this->getPageURL('Verein'); ?>">Der Verein</a>
                    <ul class="menu">
                        <li class="first leaf"><a href="<?php echo $this->getPageURL('Verein'); ?>">Über uns</a></li>
                        <li class="leaf"><a href="<?php echo $this->getPageURL('Mitglied_werden'); ?>">Mitglied werden</a></li>
                        <li class="leaf"><a href="<?php echo $this->getPageURL('Anfahrt'); ?>">Anfahrt</a></li>
                        <li class="leaf"><a href="<?php echo $this->getPageURL('Presse'); ?>">Presse</a></li>
                        <li class="leaf"><a href="<?php echo $this->getPageURL('Spacewalk'); ?>">Virtuelle Tour</a></li>
                        <li class="leaf"><a href="<?php echo $this->getPageURL('Kommunikation'); ?>">Kommunikation</a></li>
                        <li class="leaf"><a href="http://getdigital.de/products/Backspace" target="_blank">Merchandise</a></li>
                        <li class="leaf"><a href="<?php echo $this->getPageURL('Raum-FAQ'); ?>">FAQ</a></li>
                        <li class="last leaf"><a href="<?php echo $this->getPageURL('Verein:Willkommen'); ?>">Willkommen</a>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $this->getPageURL('Events') ?>">Events</a>
                </li>
                <li class="nolink expandable">
                    <span>Sonstiges</span>
                    <ul class="menu">
                        <li class="first leaf"><a href="<?php echo $this->getPageURL('Category:Howto'); ?>">HowTo</a></li>
                	<li class="leaf"><a href="<?php echo $this->getPageURL('Gallery'); ?>">Gallery</a></li>
                        <li class="leaf"><a href="<?php echo $this->getPageURL('Sponsoring'); ?>">Sponsoren</a></li>
                        <li class="last leaf"><a href="<?php echo $this->getPageURL('Verein:Preisliste'); ?>">Preisliste</a>
                    </ul>
                </li>
                <li class="last leaf"><a href="<?php echo $this->getPageURL('Kontakt'); ?>">Kontakt</a></li>
            </ul>
        </div>

        <div id="bs-content">
            <div id="bs-content-wrapper">
                <?php if( !in_array( $curTitle, array('Main_Page', 'Hauptseite') ) ): ?>
                <ul id="bs-cactions"><?php
                    foreach($this->data['content_actions'] as $key => $tab) {
                        echo $this->makeListItem( $key, $tab );
                    } ?>

                </ul>
                <?php endif; ?>

	        <h1 id="firstHeading" class="firstHeading"><?php $this->html('title') ?></h1>
		<?php $this->html('subtitle'); ?>
                <?php $this->html('bodytext'); ?>
                <?php if($this->data['dataAfterContent']) { $this->html ('dataAfterContent'); } ?>

                <?php if( $this->data['catlinks'] ) { $this->html('catlinks'); } ?>
                <div class="visualClear"></div>
            </div>
        </div>

        <div class="rich-navigation clearfix">
            <div class="nav-group">
                <h4>Social Media</h4>
                <ul class="nav-social-media">
                    <li><a href="https://twitter.com/b4ckspace">twitter</a></li>
                    <li><a href="https://vimeo.com/backspace">vimeo</a></li>
                    <li><a href="https://github.com/b4ckspace">github</a></li>
                </ul>
            </div>
            <div class="nav-group">
                <h4>Spenden</h4>
                <ul class="nav-spenden">
                    <li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=finanzen%40hackerspace-bamberg.de&lc=DE&item_name=backspace%20e.%20V.&item_number=backspace%20allgemein&no_note=0&currency_code=EUR&bn=PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest">PayPal</a></li>
                    <li><a href="https://flattr.com/profile/b4ckspace">Flattr</a></li>
                    <li><a href="<?php echo $this->getPageURL('Sponsoring#Bank.C3.BCberweisung'); ?>">&Uuml;berweisung</a></li>
                </ul>
            </div>
            <div class="nav-group">
                <h4>Der Verein</h4>
                <ul class="nav-verein">
                    <li><a href="<?php echo $this->getPageURL('Verein'); ?>">backspace e.V.</a></li>
                    <li><a href="<?php echo $this->getPageURL('Mitglied_werden'); ?>">Mitglied werden</a></li>
                    <li><a href="<?php echo $this->getPageURL('Anfahrt'); ?>">Anfahrt</a></li>
                    <li><a href="<?php echo $this->getPageURL('Kommunikation'); ?>">Kontakt</a></li>
                </ul>
            </div>
            <div class="nav-group">
                <h4>Sonstiges</h4>
                <ul class="nav-address">
                    <li><a href="<?php echo $this->getPageURL('Impressum'); ?>">Impressum</a></li>
                    <li><a href="<?php echo $this->getPageURL('Datenschutz'); ?>">Datenschutz</a></li>
                </ul>
            </div>
            <div class="nav-group">
                <h4>Anschrift</h4>
                <div class="nav-address">
                    backspace e.V.<br>
                    Spiegelgraben 41<br>
                    96052 Bamberg
                </div>

                <div class="nav-phone">
                    Tel: (0951) 18 50 51 45<br>
                </div>
            </div>
        </div>
</div>
<?php
		$this->printTrail();
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
	}
} // end of class
