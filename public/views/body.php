
        </div>

        <form id="cvForm" action="/Php_structure/public/views/preview_cv.php" method="post" class="builder" novalidate>
            <!-- PERSONAL -->
            <div class="section-card">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="mb-2 text-white">Personal Information</h5>
                    <small class="muted">always visible</small>
                </div>

                <div class="row g-2">
                    <div class="col-md-6">
                        <input name="full_name" class="form-control form-control-lg" placeholder="Full name (e.g. John Doe)" required>
                    </div>
                    <div class="col-md-6">
                        <input name="job_title" class="form-control form-control-lg" placeholder="Professional title (e.g. Full Stack Developer)">
                    </div>

                    <div class="col-md-4">
                        <input name="email" type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="col-md-4">
                        <input name="phone" class="form-control" placeholder="Phone">
                    </div>
                    <div class="col-md-4">
                        <input name="location" class="form-control" placeholder="Location (City, Country)">
                    </div>

                    <div class="col-md-6 mt-2">
                        <input name="linkedin" class="form-control" placeholder="LinkedIn URL">
                    </div>
                    <div class="col-md-6 mt-2">
                        <input name="github" class="form-control" placeholder="GitHub / Portfolio URL">
                    </div>
                </div>
            </div>

            <!-- SUMMARY -->
            <div class="section-card">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-2 text-white">Professional Summary</h5>
                    <small class="muted">short 2-4 lines</small>
                </div>
                <textarea name="summary" class="form-control" rows="3" placeholder="A concise summary about you..."></textarea>
            </div>

            <!-- SKILLS -->
            <div id="skillsCard" class="section-card">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-2 text-white">Skills</h5>
                    <div><small class="muted">add top skills (tags)</small></div>
                </div>

                <div id="skillsList" class="mb-2">
                    <!-- single skill input template -->
                    <div class="input-group mb-2 skill-item">
                        <input name="skills[]" class="form-control" placeholder="e.g. PHP, Laravel" />
                        <button type="button" class="btn del-btn" onclick="removeParent(this)">Delete</button>
                    </div>
                </div>

                <button type="button" class="add-btn" onclick="addSkill()">+ Add Skill</button>
            </div>

            <!-- EXPERIENCE -->
            <div id="expCard" class="section-card">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-2 text-white">Experience</h5>
                    <small class="muted">most recent first</small>
                </div>

                <div id="expList">
                    <div class="experience-item mb-3 p-2 rounded" style="background:rgba(255,255,255,0.02);">
                        <div class="row g-2">
                            <div class="col-md-6"><input name="exp_company[]" class="form-control" placeholder="Company"></div>
                            <div class="col-md-6"><input name="exp_title[]" class="form-control" placeholder="Role / Title"></div>
                            <div class="col-md-4 mt-2"><input name="exp_start[]" class="form-control" placeholder="Start (e.g. Jan 2021)"></div>
                            <div class="col-md-4 mt-2"><input name="exp_end[]" class="form-control" placeholder="End (e.g. Present / Jul 2023)"></div>
                            <div class="col-md-4 mt-2"><input name="exp_location[]" class="form-control" placeholder="Location"></div>
                            <div class="col-12 mt-2"><textarea name="exp_description[]" class="form-control" rows="3" placeholder="Achievements & responsibilities (bullet points separated by ';')"></textarea></div>
                        </div>
                        <div class="mt-2 text-end"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete Experience</button></div>
                    </div>
                </div>

                <div class="mt-1">
                    <button type="button" class="add-btn" onclick="addExperience()">+ Add Experience</button>
                </div>
            </div>

            <!-- EDUCATION -->
            <div id="eduCard" class="section-card">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-2 text-white">Education</h5>
                    <small class="muted">degrees & institutes</small>
                </div>

                <div id="eduList">
                    <div class="education-item mb-3 p-2 rounded" style="background:rgba(255,255,255,0.02);">
                        <div class="row g-2">
                            <div class="col-md-6"><input name="edu_degree[]" class="form-control" placeholder="Degree"></div>
                            <div class="col-md-6"><input name="edu_school[]" class="form-control" placeholder="Institution"></div>
                            <div class="col-md-4 mt-2"><input name="edu_start[]" class="form-control" placeholder="Start Year"></div>
                            <div class="col-md-4 mt-2"><input name="edu_end[]" class="form-control" placeholder="End Year"></div>
                            <div class="col-md-4 mt-2"><input name="edu_location[]" class="form-control" placeholder="Location"></div>
                        </div>
                        <div class="mt-2 text-end"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete Education</button></div>
                    </div>
                </div>

                <div class="mt-1">
                    <button type="button" class="add-btn" onclick="addEducation()">+ Add Education</button>
                </div>
            </div>

            <!-- PROJECTS -->
            <div id="projCard" class="section-card">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-2 text-white">Projects</h5>
                    <small class="muted">optional</small>
                </div>

                <div id="projList">
                    <div class="project-item mb-3 p-2 rounded" style="background:rgba(255,255,255,0.02);">
                        <div class="row g-2">
                            <div class="col-md-6"><input name="proj_name[]" class="form-control" placeholder="Project name"></div>
                            <div class="col-md-6"><input name="proj_tech[]" class="form-control" placeholder="Tech used (comma separated)"></div>
                            <div class="col-12 mt-2"><textarea name="proj_desc[]" class="form-control" rows="2" placeholder="Short description"></textarea></div>
                            <div class="col-12 mt-2"><input name="proj_link[]" class="form-control" placeholder="Link (GitHub / Live)"></div>
                        </div>
                        <div class="mt-2 text-end"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete Project</button></div>
                    </div>
                </div>

                <div class="mt-1">
                    <button type="button" class="add-btn" onclick="addProject()">+ Add Project</button>
                </div>
            </div>

            <!-- Certifications, Languages, Achievements, Interests, References, Custom -->
            <div id="miscCard" class="section-card">
                <div class="row g-2">
                    <div class="col-md-6">
                        <h6 class="text-white">Certifications</h6>
                        <div id="certList">
                            <div class="input-group mb-2 cert-item">
                                <input name="cert_name[]" class="form-control" placeholder="Certificate name">
                                <button type="button" class="btn del-btn" onclick="removeParent(this)">Delete</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addCert()">+ Add Cert</button>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-white">Languages</h6>
                        <div id="langList">
                            <div class="input-group mb-2 lang-item">
                                <input name="lang_name[]" class="form-control" placeholder="Language">
                                <input name="lang_level[]" class="form-control" placeholder="Level (e.g. Native / Fluent)">
                                <button type="button" class="btn del-btn" onclick="removeParent(this)">Delete</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addLang()">+ Add Language</button>
                    </div>

                    <div class="col-md-6 mt-3">
                        <h6 class="text-white">Achievements / Awards</h6>
                        <div id="achList">
                            <div class="input-group mb-2 ach-item">
                                <input name="ach_name[]" class="form-control" placeholder="Award / Achievement">
                                <button type="button" class="btn del-btn" onclick="removeParent(this)">Delete</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addAch()">+ Add Achievement</button>
                    </div>

                    <div class="col-md-6 mt-3">
                        <h6 class="text-white">Interests / Hobbies</h6>
                        <div id="intList">
                            <div class="input-group mb-2 int-item">
                                <input name="interest[]" class="form-control" placeholder="e.g. Photography">
                                <button type="button" class="btn del-btn" onclick="removeParent(this)">Delete</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addInterest()">+ Add Interest</button>
                    </div>

                    <div class="col-12 mt-3">
                        <h6 class="text-white">References</h6>
                        <div id="refList">
                            <div class="ref-item mb-2 p-2 rounded" style="background:rgba(255,255,255,0.02);">
                                <div class="row g-2">
                                    <div class="col-md-4"><input name="ref_name[]" class="form-control" placeholder="Ref name"></div>
                                    <div class="col-md-4"><input name="ref_position[]" class="form-control" placeholder="Position"></div>
                                    <div class="col-md-4"><input name="ref_contact[]" class="form-control" placeholder="Contact info"></div>
                                </div>
                                <div class="mt-2 text-end"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete Reference</button></div>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addRef()">+ Add Reference</button>
                    </div>

                    <div class="col-12 mt-3">
                        <h6 class="text-white">Custom Sections</h6>
                        <div id="customList">
                            <div class="custom-item mb-2 p-2 rounded" style="background:rgba(255,255,255,0.02);">
                                <input name="custom_title[]" class="form-control mb-2" placeholder="Section Title (e.g. Volunteering)">
                                <textarea name="custom_content[]" class="form-control" rows="2" placeholder="Content / details"></textarea>
                                <div class="mt-2 text-end"><button type="button" class="btn del-btn" onclick="removeParent(this)">Delete Custom</button></div>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addCustom()">+ Add Custom Section</button>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-lg btn-light small-btn">Generate CV →</button>
            </div>
        </form>