/* global AxiomBuilderConfig */
(function () {
  const app = document.getElementById("axiom-editor-app");
  if (!app) {
    return;
  }

  const endpoint = app.getAttribute("data-endpoint") || (AxiomBuilderConfig && AxiomBuilderConfig.restUrl) || "";
  app.innerHTML = `
    <div class="axiom-editor-shell">
      <div class="axiom-editor-topbar">
        <strong>Axiom Builder MVP</strong>
        <button id="axiom-load-templates" type="button">Load templates</button>
      </div>
      <pre id="axiom-editor-output">REST endpoint: ${endpoint}</pre>
    </div>
  `;

  const loadButton = document.getElementById("axiom-load-templates");
  const output = document.getElementById("axiom-editor-output");
  if (!loadButton || !output) {
    return;
  }

  loadButton.addEventListener("click", async () => {
    try {
      const response = await fetch(`${endpoint}/templates`, {
        headers: {
          "X-WP-Nonce": (AxiomBuilderConfig && AxiomBuilderConfig.nonce) || "",
        },
      });
      const json = await response.json();
      output.textContent = JSON.stringify(json, null, 2);
    } catch (error) {
      output.textContent = `Failed to load templates: ${String(error)}`;
    }
  });
})();
