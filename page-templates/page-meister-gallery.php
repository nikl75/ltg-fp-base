<?php
/*
Template Name: Meister Galerie
*/
$tQuery;
get_header(); ?>

<?php get_template_part('template-parts/featured-image'); ?>
<div class="main-container">
	<div class="main-grid grid-margin-x grid-x grid-margin-y">

		<?php if (!get_field('holzh_titel_verbergen', get_the_ID())) : ?>
			<header class="cell small-12">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
		<?php endif; ?>
		<?php
		$args = array('order' => 'DESC');
		$member_group_terms = get_terms('jahr', $args);



		if ($member_group_terms) {
			// echo '$member_group_terms';
			foreach ($member_group_terms as $member_group_term) {
				echo '<div class="cell small-12 liste-werk liste-jahr">' . $member_group_term->name . '</div>';
				$tS = werkeSammeln($member_group_term);
				werkeShowList($tS);
			}
		} else {
			// echo '$member_group_terms empty';
			$tS = werkeSammeln('');
			werkeShowList($tS);
		}

		?>
	</div>
</div>
<?php get_footer();

function werkeSammeln($tTerms)
{
	if ($tTerms != '') {
		$tTt = array(
			array(
				'taxonomy' => 'jahr',
				'field' => 'slug',
				'terms' => array($tTerms->slug),
				'operator' => 'IN',
			)
		);
	} else {
		$tTt = '';
	}
	$tQuery = new WP_Query(array(
		'post_type' => 'werke',
		'tax_query' => $tTt
	));
	return $tQuery;
}

function werkeShowList($tWerkList)
{
	if ($tWerkList->have_posts()) {
		while ($tWerkList->have_posts()) {
			$tWerkList->the_post();

			// getting field-group galerie and count difference to 4
			$images = get_field('holzh_galerie');
			$size = 'holzh_werk_gal';
			$tIC = (count($images) < 4) ? count($images) : 4;

			// getting field-group
			$name = get_field('holzh_von');

			// getting terms
			$tJ = printTermList(get_the_terms(get_the_ID(), 'jahr'));
			$tM = printTermList(get_the_terms(get_the_ID(), 'material'));
			$tO = printTermList(get_the_terms(get_the_ID(), 'objekt'));

			// build post
			if ($images) {
				for ($tImCount = 0; $tImCount <= $tIC - 1; $tImCount++) {
					echo '<a href="' . $images[$tImCount]['url'] . '" data-fancybox="gal-' . get_the_ID() . '" class="liste-werk-werk-bild small-12 medium-6 large-3 cell">';
					echo wp_get_attachment_image($images[$tImCount]['ID'], $size);
					echo '<div class="holzh-caption-trigger"><div class="holzh-caption liste werk">' . get_the_title() . '</div></div>';
					echo '</a>';
				}
				for ($tNonImCount = 0; $tNonImCount <= 3 - $tIC; $tNonImCount++) {
					echo '<div class="holzh-spacer cell medium-6 large-3 hide-for-small-only"></div>';
				}
			}

			echo
				'
				<div class="holzh-info is-hidden" id="holzh-infobox-' . get_the_ID() . '">
				<div class="holzh-term-objekt">' . $tO . '</div>
				<div class="holzh-title"><h2>' . get_the_title() . '</h2></div>
				<div class="holzh-untertitel">' . get_field('holzh_untertitel') . '</div>
				<div class="holzh-terms-material">' . $tM . '</div>
				<div class="holzh-name">' . $name['holzh_gef_vorname'] . ' ' . $name['holzh_gef_nachname'] . '</div>
				<div class="holzh-kontakt">' . get_field('holzh_kontakt') . '</div>
				<div class="holzh-e-mail"><a href="mailto:' . get_field('holzh_e-mail') . '">' . get_field('holzh_e-mail') . '</a></div>
				<div class="holzh-gefertigt-bei">' . get_field('holzh_gefertigt_bei') . '</div>
				<div class="holzh-ausbildungsbetrieb">' . get_field('holzh_ausbildungsbetrieb') . '</div>
				<div class="holzh-term-jahr">' . $tJ . '</div>
			</div>';
		}
	}

	// Reset things, for good measure
	$member_group_query = null;
	wp_reset_postdata();
}

function printTermList($tTerms)
{
	$re = array();
	if(! empty($tTerms)){
		foreach ($tTerms as $tT) {
			array_push($re, $tT->name );
		}
	}
	$re = implode('<br/>', $re);
	return $re;
}
