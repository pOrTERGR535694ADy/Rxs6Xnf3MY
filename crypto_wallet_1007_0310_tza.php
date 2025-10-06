<?php
// 代码生成时间: 2025-10-07 03:10:30
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

/**
 * Crypto Wallet Model
 *
 * Represents a cryptocurrency wallet and its transactions.
 */
class CryptoWallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'address',
        'balance',
        'currency'
    ];

    /**
     * Get the user that owns the wallet.
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Add funds to the wallet.
     *
     * @param float $amount
     * @return bool
     */
    public function addFunds(float $amount): bool
    {
        if ($amount <= 0) {
            // Handle invalid amount
            return false;
        }

        $this->balance += $amount;

        return $this->save();
    }

    /**
     * Withdraw funds from the wallet.
     *
     * @param float $amount
     * @return bool
     */
    public function withdrawFunds(float $amount): bool
    {
        if ($amount <= 0 || $amount > $this->balance) {
            // Handle invalid amount or insufficient funds
            return false;
        }

        $this->balance -= $amount;

        return $this->save();
    }
}

/**
 * User Model
 *
 * Represents a user with their associated wallet.
 */
class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * Get the wallet associated with the user.
     *
     * @return HasOne
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(CryptoWallet::class, 'user_id', 'id');
    }
}

/**
 * Crypto Wallet Service
 *
 * Provides business logic for managing cryptocurrency wallets.
 */
class CryptoWalletService
{
    /**
     * Create a new cryptocurrency wallet for a user.
     *
     * @param User $user
     * @param string $currency
     * @return CryptoWallet
     */
    public function createWallet(User $user, string $currency): CryptoWallet
    {
        $wallet = new CryptoWallet(
            [
                'user_id' => $user->id,
                'address' => $this->generateAddress(),
                'balance' => 0.0,
                'currency' => $currency
            ]
        );

        $wallet->save();

        return $wallet;
    }

    /**
     * Generate a unique wallet address.
     *
     * @return string
     */
    private function generateAddress(): string
    {
        // Implement address generation logic
        return bin2hex(random_bytes(20));
    }

    /**
     * Add funds to a user's wallet.
     *
     * @param CryptoWallet $wallet
     * @param float $amount
     * @return bool
     */
    public function addFundsToWallet(CryptoWallet $wallet, float $amount): bool
    {
        return $wallet->addFunds($amount);
    }

    /**
     * Withdraw funds from a user's wallet.
     *
     * @param CryptoWallet $wallet
     * @param float $amount
     * @return bool
     */
    public function withdrawFundsFromWallet(CryptoWallet $wallet, float $amount): bool
    {
        return $wallet->withdrawFunds($amount);
    }
}

// Example usage
$user = new User(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => Hash::make('password')]);
$user->save();

$walletService = new CryptoWalletService();
$wallet = $walletService->createWallet($user, 'BTC');

$walletService->addFundsToWallet($wallet, 10.0);
$walletService->withdrawFundsFromWallet($wallet, 5.0);
