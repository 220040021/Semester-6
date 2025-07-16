import time
import math
from threading import Thread, Lock
from multiprocessing import Process, Manager
import asyncio

# Fungsi cek bilangan prima
def is_prime(n):
    if n < 2:
        return False
    if n == 2:
        return True
    if n % 2 == 0:
        return False
    sqrt_n = int(math.sqrt(n)) + 1
    for i in range(3, sqrt_n, 2):
        if n % i == 0:
            return False
    return True

# Fungsi pembagi range menjadi batch
def chunkify(start, end, chunks):
    step = (end - start) // chunks
    return [(start + i * step, start + (i + 1) * step if i < chunks - 1 else end) for i in range(chunks)]

# THREADING
def find_primes_threaded(start, end, results, lock):
    local_primes = [n for n in range(start, end) if is_prime(n)]
    with lock:
        results.extend(local_primes)

def run_threading(start=1, end=100000, threads=4):
    results = []
    threads_list = []
    ranges = chunkify(start, end, threads)
    lock = Lock()

    for r in ranges:
        t = Thread(target=find_primes_threaded, args=(r[0], r[1], results, lock))
        threads_list.append(t)
        t.start()

    for t in threads_list:
        t.join()

    return results

# MULTIPROCESSING
def find_primes_multiprocess(start, end, results):
    primes = [n for n in range(start, end) if is_prime(n)]
    results.extend(primes)

def run_multiprocessing(start=1, end=100000, processes=4):
    with Manager() as manager:
        results = manager.list()
        process_list = []
        ranges = chunkify(start, end, processes)

        for r in ranges:
            p = Process(target=find_primes_multiprocess, args=(r[0], r[1], results))
            process_list.append(p)
            p.start()

        for p in process_list:
            p.join()

        return list(results)

# ASYNCIO
def find_primes_range(start, end):
    return [n for n in range(start, end) if is_prime(n)]

async def run_asyncio(start=1, end=100000, tasks=4):
    ranges = chunkify(start, end, tasks)
    tasks_list = [asyncio.to_thread(find_primes_range, r[0], r[1]) for r in ranges]
    results = await asyncio.gather(*tasks_list)
    return [prime for sublist in results for prime in sublist]

# MAIN TEST
def main():
    print("Testing THREADING:")
    start_time = time.time()
    result_thread = run_threading(threads=4)  # Reduce thread count to avoid RuntimeError
    print(f"Threading took {time.time() - start_time:.2f} seconds. Total primes: {len(result_thread)}")

    print("\nTesting MULTIPROCESSING:")
    start_time = time.time()
    result_multi = run_multiprocessing(processes=4)
    print(f"Multiprocessing took {time.time() - start_time:.2f} seconds. Total primes: {len(result_multi)}")

    print("\nTesting ASYNCIO:")
    start_time = time.time()
    result_async = asyncio.run(run_asyncio(tasks=4))
    print(f"Asyncio took {time.time() - start_time:.2f} seconds. Total primes: {len(result_async)}")

if __name__ == "__main__":
    main()
