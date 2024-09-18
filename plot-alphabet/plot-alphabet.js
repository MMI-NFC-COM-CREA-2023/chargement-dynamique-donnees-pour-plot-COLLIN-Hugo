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