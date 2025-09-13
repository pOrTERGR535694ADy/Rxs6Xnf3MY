<?php
// 代码生成时间: 2025-09-13 13:27:55
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * AuditLogController - Controller for handling audit log operations.
 */
class AuditLogController extends Controller
{
    /**
     * Store a newly created audit log in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'action' => 'required|string',
                'description' => 'required|string',
            ]);

            // Create a new audit log entry
            $auditLog = new AuditLog();
            $auditLog->user_id = $validatedData['user_id'];
            $auditLog->action = $validatedData['action'];
            $auditLog->description = $validatedData['description'];
            $auditLog->save();

            return response()->json(['message' => 'Audit log created successfully.', 'data' => $auditLog], 201);
        } catch (\Exception $e) {
            // Handle exception and return an error response
            return response()->json(['error' => 'Failed to create audit log.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified audit log.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $auditLog = AuditLog::findOrFail($id);
            return response()->json(['data' => $auditLog], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Audit log not found.', 'message' => $e->getMessage()], 404);
        }
    }
}

/**
 * AuditLog - Model for representing audit log entries.
 */
class AuditLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'action', 'description'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];
}

/**
 * Migration for creating the audit_logs table.
 */
class CreateAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('action');
            $table->text('description');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
}
?