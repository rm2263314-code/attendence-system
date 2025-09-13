// Password Toggle Function
function togglePassword(inputId, toggleId) {
  const passwordInput = document.getElementById(inputId);
  const toggleButton = document.getElementById(toggleId);
  
  if (passwordInput && toggleButton) {
    toggleButton.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      
      // Update icon
      if (type === 'password') {
        toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
      } else {
        toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
      }
    });
  }
}

// Sidebar Toggle
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  if (sidebar) {
    sidebar.classList.toggle('active');
  }
}

// Loading Spinner
function showLoading(elementId) {
  const element = document.getElementById(elementId);
  if (element) {
    element.innerHTML = '<div class="spinner"></div>';
  }
}

function hideLoading(elementId) {
  const element = document.getElementById(elementId);
  if (element) {
    element.innerHTML = '';
  }
}

// Chart.js Initialization
function initializeCharts() {
  // Attendance Trend Chart
  if (document.getElementById('attendanceChart')) {
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
        datasets: [{
          label: 'Attendance',
          data: [95, 93, 88, 92, 90],
          borderColor: '#2563eb',
          tension: 0.4,
          fill: false
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 100
          }
        }
      }
    });
  }
}

// Table Search and Sort
function initializeTable(tableId) {
  const table = document.getElementById(tableId);
  if (!table) return;

  const headers = table.querySelectorAll('th');
  headers.forEach((header, index) => {
    header.addEventListener('click', () => {
      sortTable(table, index);
    });
  });
}

function sortTable(table, column) {
  const rows = Array.from(table.querySelectorAll('tr:not(:first-child)'));
  const direction = table.dataset.sortDirection === 'asc' ? -1 : 1;
  
  rows.sort((a, b) => {
    const aCol = a.querySelector(`td:nth-child(${column + 1})`).textContent.trim();
    const bCol = b.querySelector(`td:nth-child(${column + 1})`).textContent.trim();
    return aCol > bCol ? direction : -direction;
  });
  
  table.dataset.sortDirection = direction === 1 ? 'asc' : 'desc';
  
  rows.forEach(row => table.appendChild(row));
}

// Search Function
function searchTable(inputId, tableId) {
  const input = document.getElementById(inputId);
  const table = document.getElementById(tableId);
  if (!input || !table) return;

  input.addEventListener('keyup', function() {
    const filter = input.value.toLowerCase();
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
      const row = rows[i];
      const cells = row.getElementsByTagName('td');
      let found = false;

      for (let j = 0; j < cells.length; j++) {
        const cell = cells[j];
        if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
          found = true;
          break;
        }
      }

      row.style.display = found ? '' : 'none';
    }
  });
}

// Simulated attendance marking
function simulateAttendance() {
    const scanner = document.getElementById('scanner');
    const status = document.getElementById('scan-status');
    
    scanner.classList.add('scanning');
    status.textContent = 'Scanning fingerprint...';
    
    // Simulate scanning delay
    setTimeout(() => {
        // Sample student data - in real system, this would come from fingerprint scan
        const students = [
            { id: 'ST001', name: 'Rahul Kumar', class: '5A' },
            { id: 'ST002', name: 'Priya Sharma', class: '6B' },
            { id: 'ST003', name: 'Amit Singh', class: '5A' }
        ];
        
        const student = students[Math.floor(Math.random() * students.length)];
        
        // Send attendance data to server
        fetch('mark_attendance.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `mark_attendance=1&student_id=${student.id}&student_name=${student.name}&class=${student.class}&status=present`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                status.textContent = `✅ Attendance marked for ${student.name}`;
                updateAttendanceTable();
            } else {
                status.textContent = '❌ Error marking attendance';
            }
        })
        .catch(error => {
            status.textContent = '❌ Error marking attendance';
        })
        .finally(() => {
            scanner.classList.remove('scanning');
            setTimeout(() => {
                status.textContent = 'Ready to scan fingerprint...';
            }, 3000);
        });
    }, 1500);
}

// Update attendance table with latest records
function updateAttendanceTable() {
    const tbody = document.getElementById('attendanceTableBody');
    if (!tbody) return;

    fetch('get_attendance.php')
        .then(response => response.json())
        .then(data => {
            tbody.innerHTML = data.records.map(record => `
                <tr>
                    <td>${record.student_id}</td>
                    <td>${record.student_name}</td>
                    <td>${record.class}</td>
                    <td>${record.date}</td>
                    <td>${record.time}</td>
                    <td><span class="badge ${record.status}">${record.status}</span></td>
                </tr>
            `).join('');
        });
}

// Initialize tooltips
function initTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', e => {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = element.dataset.tooltip;
            document.body.appendChild(tooltip);
            
            const rect = element.getBoundingClientRect();
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
            tooltip.style.left = rect.left + (rect.width - tooltip.offsetWidth) / 2 + 'px';
        });

        element.addEventListener('mouseleave', () => {
            const tooltip = document.querySelector('.tooltip');
            if (tooltip) tooltip.remove();
        });
    });
}