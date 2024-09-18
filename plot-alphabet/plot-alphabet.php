<?php
/**
 * Affiche alphabet graph
 *
 * @package   Affiche_Alphabet_Graph
 *
 * @wordpress-plugin
 * Plugin Name:       Affiche alphabet graph
 * Description:       Cherche un ID "graph-aphabet" et place un graphique dedans
 */

// https://developer.wordpress.org/plugins/plugin-basics/best-practices/#avoiding-direct-file-access
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

'plot-alphabet.php' :

function register_plot_alphabet_scripts()
{
    wp_register_script('d3','https://cdn.jsdelivr.net/npm/d3@7',null, '7.0', array(
        'strategy'  => 'defer',
    ));
    wp_register_script('plot','https://cdn.jsdelivr.net/npm/@observablehq/plot@0.6',array('d3'), '0.6', array(
        'strategy'  => 'defer',
    ));
    wp_enqueue_script('plot-alphabet', plugins_url('plot-alphabet.js', __FILE__ ), array('plot'), '1.0', array(
        'strategy'  => 'defer',
    ));
    wp_localize_script('plot-alphabet', 'plotAlphabet', array("json"=>plugins_url('alphabet.json', __FILE__ )));
}
add_action('wp_enqueue_scripts', 'register_plot_alphabet_scripts');
Remarque : si on avait fait la même chose dans le 'functions.php' du template : on aurait utilisé 'get_template_directory_uri' à la place de 'plugins_url'.

'plot-alphabet.js' :

// async IIFE
(async () => {
  console.log(plotAlphabet)

  const div = document.querySelector("#graph-alphabet");
  if (div) {
    //const plot = Plot.rectY({ length: 10000 }, Plot.binX({ y: "count" }, { x: Math.random })).plot();

    const alphabetResponse = await fetch(plotAlphabet.json);
    const alphabet = await alphabetResponse.json();

    const plot = Plot.plot({
    marks: [
      Plot.barY(alphabet, { x: "letter", y: "frequency" }),
      Plot.ruleY([0])
    ]
  });

    div.append(plot);
  } else {
    console.error("Pas trouvé de ID 'graph-alphabet'");
  }
})();
