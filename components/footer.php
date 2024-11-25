  <!-- footer -->
  <div class="container-fluid">
      <div class="footer">
          <p>Infinity Networks Copyright © 2024 . All rights reserved.<br><br>
              Designed & Codded by: <i class="fa fa-github"></i> <a href="https://github.com/devRG7">Ramlochund Gitendrajeet</a>
          </p>
      </div>
  </div>
  </div>
  <!-- end dashboard inner -->
  </div>
  </div>
  </div>
  <!-- jQuery -->
  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/popper.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>


  <!-- wow animation -->
  <script src="../../js/animate.js"></script>
  <!-- select country -->
  <script src="../../js/bootstrap-select.js"></script>
  <!-- owl carousel -->
  <script src="../../js/owl.carousel.js"></script>
  <!-- chart js -->
  <script src="../../js/Chart.min.js"></script>
  <script src="../../js/Chart.bundle.min.js"></script>
  <script src="../../js/utils.js"></script>
  <script src="../../js/analyser.js"></script>
  <!-- nice scrollbar -->
  <script src="../../js/perfect-scrollbar.min.js"></script>
  <script>
      var ps = new PerfectScrollbar('#sidebar');
  </script>
  <!-- custom js -->
  <script src="../../js/custom.js"></script>
  <script src="../../js/chart_custom_style2.js"></script>
  <!-- Script for Image Preview -->
  <script type="text/javascript">
      function preview() {
          frame.src = URL.createObjectURL(event.target.files[0]);
      }
  </script>
  <!-- Include SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>

  <script>
      function sortTable(n) {
          var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
          table = document.getElementById("myTable");
          if (!table) {
              console.error("Table not found");
              return;
          }

          switching = true;
          dir = "asc";

          while (switching) {
              switching = false;
              rows = table.rows;

              for (i = 1; i < rows.length - 1; i++) {
                  shouldSwitch = false;

                  x = rows[i].getElementsByTagName("td")[n];
                  y = rows[i + 1].getElementsByTagName("td")[n];

                  if (x && y) {
                      var xText = x.textContent || x.innerText;
                      var yText = y.textContent || y.innerText;

                      if ((dir === "asc" && xText.localeCompare(yText) > 0) || (dir === "desc" && xText.localeCompare(yText) < 0)) {
                          shouldSwitch = true;
                          break;
                      }
                  }
              }

              if (shouldSwitch) {
                  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                  switching = true;
                  switchcount++;
              } else {
                  if (switchcount === 0 && dir === "asc") {
                      dir = "desc";
                      switching = true;
                  }
              }
          }
      }
  </script>
  <script>
      function mySearch() {
          var input, filter, table, tr, td, i, txtValue, visibleRowCount;
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          table = document.getElementById("myTable");
          tr = table.getElementsByTagName("tr");
          visibleRowCount = 0; // Initialize the count of visible rows

          for (i = 0; i < tr.length; i++) {
              td = tr[i].getElementsByTagName("td")[1]; // Adjust the index based on the column you want to search
              if (td) {
                  txtValue = td.textContent || td.innerText;
                  if (txtValue.toUpperCase().indexOf(filter) > -1) {
                      tr[i].style.display = "";
                      visibleRowCount++; // Increment visible row count
                  } else {
                      tr[i].style.display = "none";
                  }
              }
          }

          // Show/hide the "No results" message row based on displayed rows
          var noResultsMessage = document.getElementById("noResultsMessage");
          if (visibleRowCount === 0) {
              noResultsMessage.style.display = "table-row";
          } else {
              noResultsMessage.style.display = "none";
          }
      }
  </script>