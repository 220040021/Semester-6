import random
import time
import sys
import tkinter as tk
from tkinter import messagebox

def dice_roll(sides=6):
    return random.randint(1, sides)

def play_dice_game():
    player_score = 0
    computer_score = 0
    rounds = 5
    
    sides = int(input("Enter the number of sides for the dice (6, 10, 20): "))
    if sides not in [6, 10, 20]:
        print("Invalid choice! Defaulting to 6-sided dice.")
        sides = 6
    
    for round_num in range(1, rounds + 1):
        input(f"Round {round_num}: Press Enter to roll the dice...")
        player_roll = dice_roll(sides)
        computer_roll = dice_roll(sides)
        
        print(f"You rolled: {player_roll}")
        print(f"Computer rolled: {computer_roll}")
        
        if player_roll > computer_roll:
            print("You win this round!")
            player_score += 1
        elif player_roll < computer_roll:
            print("Computer wins this round!")
            computer_score += 1
        else:
            print("It's a tie!")
        
        time.sleep(1)
        print("-")
    
    print("Final Scores:")
    print(f"You: {player_score} - Computer: {computer_score}")
    
    if player_score > computer_score:
        print("Congratulations! You win the game!")
    elif player_score < computer_score:
        print("Computer wins the game. Better luck next time!")
    else:
        print("It's a draw!")

def multiplayer_dice_game():
    players = int(input("Enter the number of players: "))
    sides = int(input("Enter the number of sides for the dice (6, 10, 20): "))
    
    scores = {f"Player {i+1}": 0 for i in range(players)}
    rounds = 5
    
    for round_num in range(1, rounds + 1):
        print(f"Round {round_num}:")
        for player in scores.keys():
            input(f"{player}, press Enter to roll the dice...")
            roll = dice_roll(sides)
            print(f"{player} rolled: {roll}")
            scores[player] += roll
        print("-")
        time.sleep(1)
    
    print("Final Scores:")
    for player, score in scores.items():
        print(f"{player}: {score}")
    
    winner = max(scores, key=scores.get)
    print(f"Congratulations! {winner} wins the game!")

def start_game(choice):
    if choice == "1":
        play_dice_game()
    elif choice == "2":
        multiplayer_dice_game()
    elif choice == "3":
        root.destroy()

def main():
    global root
    root = tk.Tk()
    root.title("Dice Game")
    root.geometry("300x200")
    
    tk.Label(root, text="Choose an option:", font=("Arial", 12)).pack(pady=10)
    tk.Button(root, text="1. Dice Battle Game (vs Computer)", command=lambda: start_game("1")).pack(fill='x', padx=20, pady=5)
    tk.Button(root, text="2. Multiplayer Dice Game", command=lambda: start_game("2")).pack(fill='x', padx=20, pady=5)
    tk.Button(root, text="3. Exit", command=lambda: start_game("3")).pack(fill='x', padx=20, pady=5)
    
    root.mainloop()

if __name__ == "__main__":
    main()