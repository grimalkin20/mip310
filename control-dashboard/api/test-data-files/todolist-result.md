# Result System Implementation Checklist

## Backend Development (API)
- [x] **Database Setup**: Run the DDL from `control-dashboard/api/results_schema.sql` to create the `results` table.
- [x] **Create API Endpoint**: Create `control-dashboard/api/get-results.php`.
    - [x] Set header `Content-Type: application/json`.
    - [x] Connect to database.
    - [x] Accept `course` parameter (optional) to filter results.
    - [x] Query the `results` table (order by year DESC, semester ASC).
    - [x] Return JSON response with success status and data.

## Frontend Integration (results.html)
- [x] **Add IDs to Table Bodies**:
    - [x] Add `id="dpharmaResults"` to D.Pharma `<tbody>`.
    - [x] Add `id="bpharmaResults"` to B.Pharma `<tbody>`.
    - [x] Add `id="mpharmaResults"` to M.Pharma `<tbody>`.
- [x] **JavaScript Implementation**:
    - [x] Create a script to fetch data from `control-dashboard/api/get-results.php`.
    - [x] Parse the JSON response.
    - [x] Group results by course (`D.Pharma`, `B.Pharma`, `M.Pharma`).
    - [x] Generate HTML rows dynamically for each group.
    - [x] Populate the respective table bodies with the generated rows.
    - [x] Handle "No results found" state.

## Admin Panel (Optional but Recommended)
- [ ] Add "Results" section to Admin Dashboard.
- [ ] Create form to Upload Result (Input: Course, Year, Sem, Type, File).
- [ ] Handle file upload to `control-dashboarduploads/materials/results` directory.
- [ ] Insert record into database.
