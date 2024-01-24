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
          switching = true;
          // Set the sorting direction to ascending:
          dir = "asc";
          /* Make a loop that will continue until
          no switching has been done: */
          while (switching) {
              // Start by saying: no switching is done:
              switching = false;
              rows = table.rows;
              /* Loop through all table rows (except the
              first, which contains table headers): */
              for (i = 1; i < (rows.length - 1); i++) {
                  // Start by saying there should be no switching:
                  shouldSwitch = false;
                  /* Get the two elements you want to compare,
                  one from current row and one from the next: */
                  x = rows[i].getElementsByTagName("td")[n];
                  y = rows[i + 1].getElementsByTagName("td")[n];
                  /* Check if the two rows should switch place,
                  based on the direction, asc or desc: */
                  if (dir == "asc") {
                      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                          // If so, mark as a switch and break the loop:
                          shouldSwitch = true;
                          break;
                      }
                  } else if (dir == "desc") {
                      if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                          // If so, mark as a switch and break the loop:
                          shouldSwitch = true;
                          break;
                      }
                  }
              }
              if (shouldSwitch) {
                  /* If a switch has been marked, make the switch
                  and mark that a switch has been done: */
                  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                  switching = true;
                  // Each time a switch is done, increase this count by 1:
                  switchcount++;
              } else {
                  /* If no switching has been done AND the direction is "asc",
                  set the direction to "desc" and run the while loop again. */
                  if (switchcount == 0 && dir == "asc") {
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