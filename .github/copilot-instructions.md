# Copilot Instructions for Disdukcapil System

## Project Overview
This is a Laravel-based Indonesian civil registration (Disdukcapil) system that manages population migration data through Excel/CSV uploads. The system tracks `datang` (incoming) and `pindah` (outgoing) population movements across different years (2024, 2025).

## Core Architecture

### Database Schema
- **Year-based tables**: `datang2024`, `datang2025`, `pindah2024`, `pindah2025`
- **Comprehensive columns**: Each table supports both simple formats (nama, alamat, tanggal) and government format with 29+ columns (NIK, NO_KK, NAMA_LENGKAP, etc.)
- **Dynamic table selection**: Routes use `{table}` parameter for CRUD operations across different year tables

### Key Models & Controllers
- `Penduduk.php`: Central model with `getRekapitulasi()` for statistics and `getDataByTable()` for querying year-specific tables
- `ExcelUploadController.php`: Handles CSV/Excel processing with automatic format detection (single vs multi-column)
- `DashboardController.php`: Main interface for viewing, editing, and deleting records

## Critical Workflows

### Excel/CSV Upload Process
```php
// Template files in public/ directory define expected formats
template_datang_lengkap.csv    // Government format (29 columns)
template_single_column_datang.csv // Simple format (3 columns)
```

### Format Detection Logic
The system automatically detects:
- **Single Column Format**: Basic data (nama, alamat, tanggal)
- **Multi Column Format**: Government standard (NIK through KODE - 29 columns)
- **File conversion**: Forces Excel → CSV conversion with detailed user instructions

### Migration Pattern
Recent migrations show evolving schema:
```php
// Add comprehensive government format columns
2025_11_17_150000_add_comprehensive_columns_to_datang_tables.php
```

## Development Patterns

### Error Handling
Always use try-catch blocks for table queries since year tables may not exist:
```php
try {
    $count = DB::table('datang2025')->count();
} catch (\Exception $e) {
    $count = 0;
}
```

### Route Structure
- Base routes: `/dashboard`, `/rekapitulasi`, `/penduduk`
- Upload routes: `/upload-excel` (GET/POST)
- Dynamic CRUD: `/penduduk/{action}/{table}/{id}`

### Data Validation
- File types: CSV, XLSX, XLS, TXT (with forced CSV conversion)
- Date formats: Multiple formats supported (Y-m-d, d/m/Y, etc.)
- Table naming: `{dataType}{year}` pattern (datang2025, pindah2024)

## Key Files for Context
- `routes/web.php`: All route definitions
- `app/Models/Penduduk.php`: Core business logic
- `database/migrations/2025_11_17_150000_*`: Latest schema structure
- `public/template_*.csv`: Data format examples
- `EXCEL_UPLOAD_GUIDE.md`: User documentation for upload process

## Common Tasks
- **Adding new year**: Create migration for new `datang{year}` and `pindah{year}` tables
- **Modifying upload logic**: Focus on `ExcelUploadController::processExcelFile()`
- **Schema changes**: Always update both datang and pindah table structures
- **Testing uploads**: Use template files in `public/` directory for format validation