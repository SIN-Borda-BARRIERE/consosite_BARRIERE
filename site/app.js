document.addEventListener("DOMContentLoaded", () => {
    console.log("Script chargé !");

    /* ======================
       HOMEPAGE
    ====================== */
    const homeForm = document.getElementById("electricity-form");

    if (homeForm) {
        homeForm.addEventListener("submit", e => {
            e.preventDefault();

            fetch("../api/save_value.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    kwh: document.getElementById("kwh").value
                })
            })
            .then(res => res.json())
            .then(data => {
                const msg = document.getElementById("form-message");
                msg.textContent = data.updated
                    ? "⚠ Consommation déjà enregistrée pour aujourd'hui (mise à jour)"
                    : "✅ Consommation enregistrée";
                homeForm.reset();
            });
        });
    }
    

    /* ======================
       DASHBOARD
    ====================== */
    const chartCanvas = document.getElementById("consumptionChart");
    const statsBox = document.getElementById("stats-box");
    let chartInstance = null;

    if (chartCanvas && window.Chart) {
        document.querySelectorAll("button[data-period]").forEach(btn => {
            btn.addEventListener("click", () => loadChart(btn.dataset.period));
        });
        loadChart("day");
    }

    function loadChart(period) {
        fetch(`../api/get_stats.php?period=${period}`)
            .then(res => res.json())
            .then(data => {
                const labels = data.map(d => d.label);
                const values = data.map(d => Number(d.total));

                if (chartInstance) chartInstance.destroy();

                chartInstance = new Chart(chartCanvas, {
                    type: "line",
                    data: {
                        labels,
                        datasets: [{
                            label: "Consommation (kWh)",
                            data: values,
                            borderWidth: 2
                        }]
                    }
                });

                if (statsBox) {
                    const total = values.reduce((a, b) => a + b, 0);
                    const avg = values.length ? (total / values.length) : 0;

                    statsBox.innerHTML = `
                        <p><strong>Total :</strong> ${total.toFixed(2)} kWh</p>
                        <p><strong>Moyenne :</strong> ${avg.toFixed(2)} kWh</p>
                    `;
                }
            });
    }

    /* ======================
       HISTORY
    ====================== */
    const historyTable = document.getElementById("history-table");

    if (historyTable) {
        fetch("../api/get_history.php")
            .then(res => res.json())
            .then(data => {
                historyTable.innerHTML = "";
                data.forEach(row => {
                    historyTable.innerHTML += `
                        <tr>
                            <td>${row.date}</td>
                            <td>
                                <input type="number" step="0.01"
                                       value="${row.kwh}" data-date="${row.date}">
                            </td>
                            <td>
                                <button class="update-btn">Modifier</button>
                            </td>
                        </tr>`;
                });
            });

        historyTable.addEventListener("click", e => {
            if (e.target.classList.contains("update-btn")) {
                const input = e.target.closest("tr").querySelector("input");
                saveValue(input.dataset.date, input.value);
            }
        });
    }

    const addForm = document.getElementById("add-history-form");
    if (addForm) {
        addForm.addEventListener("submit", e => {
            e.preventDefault();
            saveValue(
                document.getElementById("history-date").value,
                document.getElementById("history-kwh").value,
                true
            );
        });
    }

    function saveValue(date, kwh, reload = false) {
        fetch("../api/save_value.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ date, kwh })
        })
        .then(res => res.json())
        .then(() => {
            if (reload) location.reload();
        });
    }

    /* ======================
       ACCOUNT MANAGEMENT
    ====================== */

    const showUsernameBtn = document.getElementById("show-username-form");
    const showPasswordBtn = document.getElementById("show-password-form");
    const usernameForm = document.getElementById("update-username-form");
    const passwordForm = document.getElementById("update-password-form");
    const deleteForm = document.getElementById("delete-account-form");
    const accountMsg = document.getElementById("account-message");

    if (showUsernameBtn && usernameForm) {
        showUsernameBtn.addEventListener("click", () => {
            usernameForm.style.display = "block";
            showUsernameBtn.style.display = "none";
        });
        
    }

    if (showPasswordBtn && passwordForm) {
        showPasswordBtn.addEventListener("click", () => {
            passwordForm.style.display = "block";
            showPasswordBtn.style.display = "none";
        });
    }

    

    if (usernameForm) {
        usernameForm.addEventListener("submit", e => {
            e.preventDefault();
            fetch("../api/update_user.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action: "update_username",
                    username: document.getElementById("new-username").value
                })
            })
            .then(res => res.json())
            .then(data => {
                accountMsg.textContent = data.success
                    ? "✅ Pseudo mis à jour avec succès."
                    : "❌ Erreur lors de la mise à jour.";
            });
        });
    }

    if (passwordForm) {
        passwordForm.addEventListener("submit", e => {
            e.preventDefault();
            fetch("../api/update_user.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action: "update_password",
                    password: document.getElementById("new-password").value
                })
            })
            .then(res => res.json())
            .then(data => {
                accountMsg.textContent = data.success
                    ? "✅ Mot de passe modifié avec succès."
                    : "❌ Erreur lors de la modification.";
            });
        });
    }

    if (deleteForm) {
        deleteForm.addEventListener("submit", e => {
            e.preventDefault();
            if (confirm("Voulez-vous vraiment supprimer votre compte ?")) {
                fetch("../api/update_user.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ action: "delete_account" })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Compte supprimé avec succès.");
                        window.location.href = "../auth/logout.php";
                    } else {
                        accountMsg.textContent = "❌ Erreur lors de la suppression du compte.";
                    }
                });
            }
        });
    }
});