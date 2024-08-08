    </div>

    <footer class="container mt-5">
        <p class="text-muted p-0 <?php if($data['active'] == 'LoginSignUp'){$htmlOut('text-center');} ?>">
            <?php if (isset($data['lastPost'])): ?>
                <?php if ($data['lastPost'] !== null): ?>
                    Last post in this forum by <b><?php $htmlOut($data['lastPost']->author) ?> </b>
                    on <?php $htmlOut($data['lastPost']->createdAt) ?>
                <?php else: ?>
                    No posts yet
                <?php endif; ?>
            <?php endif; ?>
        </p>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        // toggle collapse button icon for community rules
        function toggleCollapseButton() {
            var button = document.getElementById("collapseRulesListButton");
            var icon = button.querySelector("i");

            if (icon.classList.contains("bi-chevron-right")) {
            icon.classList.remove("bi-chevron-right");
            icon.classList.add("bi-chevron-down");
            } else {
            icon.classList.remove("bi-chevron-down");
            icon.classList.add("bi-chevron-right");
            }
        }

        // toggle delete button icon for confirmation
        function toggleDeleteButton(prefix) {
            var id = prefix + "deleteButton"; 
            var idConfirm = prefix + "deleteButtonConfirm";
            var button = document.getElementById(id);
            var icon = button.querySelector("i");

            if (icon.classList.contains("bi-trash")) {
                icon.classList.remove("bi-trash");
                icon.classList.add("bi-x");
                button.className = "btn btn-outline-dark mr-2";
                document.getElementById(idConfirm).style.display = "inline-block";
            } else {
                icon.classList.add("bi-trash");
                icon.classList.remove("bi-x");
                button.className = "btn btn-outline-danger mr-2";
                document.getElementById(idConfirm).style.display = "none";
            }
        }
    </script>
</body>
</html>