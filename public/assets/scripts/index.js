
    /* THEME TOGGLE (persist) */
    const themeToggle = document.getElementById('themeToggle');
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
        themeToggle.textContent = '☀️';
    }
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        const isDark = document.body.classList.contains('dark-mode');
        themeToggle.textContent = isDark ? '☀️' : '🌙';
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    });

    function removeParent(btn) {
        btn.closest('.skill-item, .experience-item, .education-item, .project-item, .cert-item, .lang-item, .ach-item, .int-item, .ref-item, .custom-item')?.remove();
    }

    function addSkill() {
        const el = document.createElement('div');
        el.className = 'input-group mb-2 skill-item';
        el.innerHTML = `<input name="skills[]" class="form-control" placeholder="e.g. Node.js"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete</button>`;
        document.getElementById('skillsList').appendChild(el);
    }

    function addExperience() {
        const html = `<div class="experience-item mb-3 p-2 rounded" style="background:rgba(255,255,255,0.02);">
            <div class="row g-2">
              <div class="col-md-6"><input name="exp_company[]" class="form-control" placeholder="Company"></div>
              <div class="col-md-6"><input name="exp_title[]" class="form-control" placeholder="Role / Title"></div>
              <div class="col-md-4 mt-2"><input name="exp_start[]" class="form-control" placeholder="Start"></div>
              <div class="col-md-4 mt-2"><input name="exp_end[]" class="form-control" placeholder="End"></div>
              <div class="col-md-4 mt-2"><input name="exp_location[]" class="form-control" placeholder="Location"></div>
              <div class="col-12 mt-2"><textarea name="exp_description[]" class="form-control" rows="3" placeholder="Achievements & responsibilities (separate by ;)"></textarea></div>
            </div>
            <div class="mt-2 text-end"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete Experience</button></div>
          </div>`;
        document.getElementById('expList').insertAdjacentHTML('beforeend', html);
    }

    function addEducation() {
        const html = `<div class="education-item mb-3 p-2 rounded" style="background:rgba(255,255,255,0.02);">
            <div class="row g-2">
              <div class="col-md-6"><input name="edu_degree[]" class="form-control" placeholder="Degree"></div>
              <div class="col-md-6"><input name="edu_school[]" class="form-control" placeholder="Institution"></div>
              <div class="col-md-4 mt-2"><input name="edu_start[]" class="form-control" placeholder="Start Year"></div>
              <div class="col-md-4 mt-2"><input name="edu_end[]" class="form-control" placeholder="End Year"></div>
              <div class="col-md-4 mt-2"><input name="edu_location[]" class="form-control" placeholder="Location"></div>
            </div>
            <div class="mt-2 text-end"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete Education</button></div>
          </div>`;
        document.getElementById('eduList').insertAdjacentHTML('beforeend', html);
    }

    function addProject() {
        const html = `<div class="project-item mb-3 p-2 rounded" style="background:rgba(255,255,255,0.02);">
            <div class="row g-2">
              <div class="col-md-6"><input name="proj_name[]" class="form-control" placeholder="Project name"></div>
              <div class="col-md-6"><input name="proj_tech[]" class="form-control" placeholder="Tech used"></div>
              <div class="col-12 mt-2"><textarea name="proj_desc[]" class="form-control" rows="2" placeholder="Short description"></textarea></div>
              <div class="col-12 mt-2"><input name="proj_link[]" class="form-control" placeholder="Link"></div>
            </div>
            <div class="mt-2 text-end"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete Project</button></div>
          </div>`;
        document.getElementById('projList').insertAdjacentHTML('beforeend', html);
    }

    function addCert() {
        const el = document.createElement('div');
        el.className = 'input-group mb-2 cert-item';
        el.innerHTML = `<input name="cert_name[]" class="form-control" placeholder="Certificate"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete</button>`;
        document.getElementById('certList').appendChild(el);
    }

    function addLang() {
        const el = document.createElement('div');
        el.className = 'input-group mb-2 lang-item';
        el.innerHTML = `<input name="lang_name[]" class="form-control" placeholder="Language"><input name="lang_level[]" class="form-control" placeholder="Level"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete</button>`;
        document.getElementById('langList').appendChild(el);
    }

    function addAch() {
        const el = document.createElement('div');
        el.className = 'input-group mb-2 ach-item';
        el.innerHTML = `<input name="ach_name[]" class="form-control" placeholder="Achievement"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete</button>`;
        document.getElementById('achList').appendChild(el);
    }

    function addInterest() {
        const el = document.createElement('div');
        el.className = 'input-group mb-2 int-item';
        el.innerHTML = `<input name="interest[]" class="form-control" placeholder="Interest"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete</button>`;
        document.getElementById('intList').appendChild(el);
    }

    function addRef() {
        const html = `<div class="ref-item mb-2 p-2 rounded" style="background:rgba(255,255,255,0.02);">
        <div class="row g-2">
          <div class="col-md-4"><input name="ref_name[]" class="form-control" placeholder="Ref name"></div>
          <div class="col-md-4"><input name="ref_position[]" class="form-control" placeholder="Position"></div>
          <div class="col-md-4"><input name="ref_contact[]" class="form-control" placeholder="Contact"></div>
        </div>
        <div class="mt-2 text-end"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete Reference</button></div>
      </div>`;
        document.getElementById('refList').insertAdjacentHTML('beforeend', html);
    }

    function addCustom() {
        const html = `<div class="custom-item mb-2 p-2 rounded" style="background:rgba(255,255,255,0.02);">
        <input name="custom_title[]" class="form-control mb-2" placeholder="Section Title">
        <textarea name="custom_content[]" class="form-control" rows="2" placeholder="Content"></textarea>
        <div class="mt-2 text-end"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete Custom</button></div>
      </div>`;
        document.getElementById('customList').insertAdjacentHTML('beforeend', html);
    }

