/**
 * Admin Calendar (FullCalendar)
 */
document.addEventListener('DOMContentLoaded', function () {
  const cfg = window.calendarConfig || {};
  const calendarEl = document.getElementById('calendar');
  if (!calendarEl || !window.FullCalendar) return;

  const {
    Calendar,
    dayGridPlugin,
    timeGridPlugin,
    listPlugin,
    interactionPlugin,
  } = window.FullCalendar;

  const modalEl = document.getElementById('eventModal');
  const modal = window.bootstrap ? new bootstrap.Modal(modalEl) : null;
  const form = document.getElementById('eventForm');
  const errorEl = document.getElementById('eventFormError');
  const titleEl = document.getElementById('eventModalTitle');
  const deleteBtn = document.getElementById('btnDeleteEvent');
  const sidebarDate = document.getElementById('calendarSidebarDate');
  const selectAll = document.getElementById('selectAll');
  const filterInputs = Array.from(document.querySelectorAll('.input-filter'));

  let selectedFilters = filterInputs.map((el) => el.dataset.value);

  function toLocalInputValue(date) {
    const d = new Date(date);
    const pad = (n) => String(n).padStart(2, '0');
    return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
  }

  function showError(message) {
    errorEl.textContent = message || 'Something went wrong.';
    errorEl.classList.remove('d-none');
  }

  function clearError() {
    errorEl.textContent = '';
    errorEl.classList.add('d-none');
  }

  function resetForm() {
    form.reset();
    document.getElementById('eventId').value = '';
    document.getElementById('eventActive').checked = true;
    deleteBtn.classList.add('d-none');
    clearError();
  }

  function openCreate(dateStr) {
    resetForm();
    titleEl.textContent = 'Add Event';
    if (dateStr) {
      const start = dateStr.includes('T') ? new Date(dateStr) : new Date(`${dateStr}T09:00:00`);
      document.getElementById('eventStart').value = toLocalInputValue(start);
    } else {
      document.getElementById('eventStart').value = toLocalInputValue(new Date());
    }
    modal && modal.show();
  }

  function openEdit(event) {
    resetForm();
    titleEl.textContent = 'Edit Event';
    document.getElementById('eventId').value = event.id;
    document.getElementById('eventTitle').value = event.title || '';
    document.getElementById('eventLabel').value = event.extendedProps.calendar || 'Business';
    document.getElementById('eventStart').value = toLocalInputValue(event.start);
    document.getElementById('eventLocation').value = event.extendedProps.location || '';
    document.getElementById('eventDescription').value = event.extendedProps.description || '';
    document.getElementById('eventActive').checked = event.extendedProps.is_active !== false;
    deleteBtn.classList.remove('d-none');
    modal && modal.show();
  }

  async function api(url, method, body) {
    const response = await fetch(url, {
      method,
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-CSRF-TOKEN': cfg.csrfToken,
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: body ? JSON.stringify(body) : undefined,
    });

    const data = await response.json().catch(() => ({}));
    if (!response.ok) {
      const message =
        data.message ||
        (data.errors && Object.values(data.errors).flat().join(' ')) ||
        'Request failed.';
      throw new Error(message);
    }
    return data;
  }

  function applyFilters() {
    selectedFilters = filterInputs.filter((el) => el.checked).map((el) => el.dataset.value);
    selectAll.checked = selectedFilters.length === filterInputs.length;
    calendar.getEvents().forEach((event) => {
      const label = event.extendedProps.calendar || 'ETC';
      const nextDisplay = selectedFilters.includes(label) ? 'auto' : 'none';
      if (event.display !== nextDisplay) {
        event.setProp('display', nextDisplay);
      }
    });
  }

  const calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'prev,next title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
    },
    buttonText: {
      month: 'Month',
      week: 'Week',
      day: 'Day',
      list: 'List',
    },
    navLinks: true,
    editable: true,
    selectable: true,
    nowIndicator: true,
    dayMaxEvents: 3,
    events: cfg.eventsUrl,
    eventDisplay: 'block',
    datesSet: function () {
      applyFilters();
    },
    eventsSet: function () {
      applyFilters();
    },
    select: function (info) {
      openCreate(info.startStr);
      calendar.unselect();
    },
    eventClick: function (info) {
      info.jsEvent.preventDefault();
      openEdit(info.event);
    },
    eventDrop: async function (info) {
      try {
        await api(`${cfg.updateUrlTemplate}/${info.event.id}`, 'PUT', {
          event_date: info.event.start.toISOString(),
        });
      } catch (err) {
        info.revert();
        alert(err.message);
      }
    },
    eventResize: async function (info) {
      try {
        await api(`${cfg.updateUrlTemplate}/${info.event.id}`, 'PUT', {
          event_date: info.event.start.toISOString(),
        });
      } catch (err) {
        info.revert();
        alert(err.message);
      }
    },
  });

  calendar.render();

  document.getElementById('btnAddEvent').addEventListener('click', function () {
    openCreate();
  });

  sidebarDate.addEventListener('change', function () {
    if (this.value) calendar.gotoDate(this.value);
  });

  selectAll.addEventListener('change', function () {
    filterInputs.forEach((el) => {
      el.checked = selectAll.checked;
    });
    applyFilters();
  });

  filterInputs.forEach((el) => {
    el.addEventListener('change', applyFilters);
  });

  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    clearError();

    const id = document.getElementById('eventId').value;
    const payload = {
      title: document.getElementById('eventTitle').value.trim(),
      tag: document.getElementById('eventLabel').value,
      event_date: document.getElementById('eventStart').value,
      location: document.getElementById('eventLocation').value.trim(),
      description: document.getElementById('eventDescription').value.trim(),
      is_active: document.getElementById('eventActive').checked,
    };

    try {
      if (id) {
        await api(`${cfg.updateUrlTemplate}/${id}`, 'PUT', payload);
      } else {
        await api(cfg.storeUrl, 'POST', payload);
      }
      modal && modal.hide();
      calendar.refetchEvents();
    } catch (err) {
      showError(err.message);
    }
  });

  deleteBtn.addEventListener('click', async function () {
    const id = document.getElementById('eventId').value;
    if (!id || !confirm('Delete this event?')) return;

    try {
      await api(`${cfg.updateUrlTemplate}/${id}`, 'DELETE');
      modal && modal.hide();
      calendar.refetchEvents();
    } catch (err) {
      showError(err.message);
    }
  });
});
